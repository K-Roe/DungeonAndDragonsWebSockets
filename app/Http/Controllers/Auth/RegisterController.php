<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use App\Http\Controllers\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // check manually for existing user (Doctrine doesn’t know Laravel’s validation rules)
        $existingUser = $this->em->getRepository(User::class)
            ->findOneBy(['email' => $validated['email']]);

        if ($existingUser) {
            throw ValidationException::withMessages([
                'email' => ['A user with this email already exists.'],
            ]);
        }

        // create and persist user
        $user = new User(
            $validated['name'],
            $validated['email'],
            Hash::make($validated['password']),
            Str::random(10)
        );

        $this->em->persist($user);
        $this->em->flush();

        // optional: auto login
        // Auth::login($user);

        return response()->json([
            'message' => 'Registration successful!',
            'user' => $user,
        ]);
    }
}
