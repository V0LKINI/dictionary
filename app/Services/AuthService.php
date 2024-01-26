<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login(string $credentials, string $password): User | Exception
    {
        $user = User::where('email', $credentials)->first();

        if (!$user) {
            throw new Exception(message: 'User not found', code: 400);
        }

        if (!Hash::check($password, $user->password)) {
            throw new Exception(message: 'Wrong password', code: 400);
        }

        $user->tokens()->where('name', 'default')->delete();

        $token = $user->createToken('default')->plainTextToken;

        $user->setAttribute('new_token', $token);

        return $user;
    }

    public function register(array $data): User | Exception
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['credentials'],
            'password' => Hash::make($data['password'])
        ]);

        $token = $user->createToken('default')->plainTextToken;

        $user->setAttribute('new_token', $token);

        return $user;
    }
}