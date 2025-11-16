<?php

namespace App\Http\Middleware;

use App\Entities\User;
use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MobileAuthMiddleware
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Expect the token in the Authorization header like: Bearer TOKEN_HERE
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'message' => 'Missing Authorization token.',
            ], 401);
        }

        // Look up the user by apiToken in your Doctrine entity
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['apiToken' => $token]);

        if (!$user) {
            return response()->json([
                'message' => 'Invalid or expired token.',
            ], 401);
        }

        // Log the user into Laravel’s Auth system for this request
        Auth::login($user);

        return $next($request);
    }
}
