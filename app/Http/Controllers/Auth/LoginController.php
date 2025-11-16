<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use App\Http\Controllers\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = $em->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['No account found for this email.'],
            ]);
        }

        // Password check
        if (!Hash::check($credentials['password'], $user->getAuthPassword())) {
            throw ValidationException::withMessages([
                'email' => ['Invalid password.'],
            ]);
        }

        // Web or Mobile?
        $isMobile = $request->header('X-APP-CLIENT') === 'mobile';

        if ($isMobile) {
            // 🔥 Mobile = token auth (NO SESSION)
            $token = $user->createToken('mobile')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token'   => $token,
                'user'    => $user,
            ]);
        }

        // 🔥 Web = normal session login
        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'message' => 'Login successful',
            'user'    => $user,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        if ($request->header('X-APP-CLIENT') === 'mobile') {
            $request->user()?->tokens()->delete();
            return response()->json(['message' => 'Logged out (mobile)']);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out']);
    }
}
