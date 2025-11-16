<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class MobileAuthController
{
    public function login(Request $request, EntityManagerInterface $em)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = $em->getRepository(User::class)->findOneBy(['email' => $request->email]);

        if (!$user || !Hash::check($request->password, $user->getAuthPassword())) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.']
            ]);
        }

        // Sanctum token (for mobile only)
        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'user' => $user->jsonSerialize(),
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }

    public function register(Request $request, EntityManagerInterface $em)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ]);

        $exists = $em->getRepository(User::class)->findOneBy(['email' => $request->email]);
        if ($exists) {
            return response()->json(['message' => 'Email already taken'], 422);
        }

        $user = new User(
            $request->name,
            $request->email,
            Hash::make($request->password)
        );

        $em->persist($user);
        $em->flush();

        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'user' => $user->jsonSerialize(),
            'token' => $token
        ]);
    }
}
