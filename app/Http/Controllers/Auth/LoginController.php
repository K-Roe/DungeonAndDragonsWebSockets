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
    /**
     * Handle user login.
     */
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

        // if you have verification logic, you can re-enable it here
        // if (!$user->isVerified()) {
        //     throw ValidationException::withMessages([
        //         'email' => ['Please verify your email before logging in.'],
        //     ]);
        // }

        // manual password check
        if (!Hash::check($credentials['password'], $user->getAuthPassword())) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // log user in through Laravel’s guard
        Auth::login($user);
        $request->session()->regenerate();

        // call any post-login methods you need (example below)
        // $user->getCurrentSubscription();

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
        ]);
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
