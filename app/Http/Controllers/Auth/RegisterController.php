<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use App\Http\Controllers\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function register(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $existing = $em->getRepository(User::class)->findOneBy(['email' => $data['email']]);

        if ($existing) {
            throw ValidationException::withMessages([
                'email' => ['Email already exists.'],
            ]);
        }

        $user = new User(
            $data['name'],
            $data['email'],
            Hash::make($data['password'])
        );

        $em->persist($user);
        $em->flush();

        return response()->json([
            'message' => 'Account created.',
            'user'    => $user,
        ]);
    }
}
