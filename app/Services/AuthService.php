<?php

namespace App\Services;

use App\Mail\PasswordRecoveryEmail;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService
{
    public function login(string $credentials, string $password): User | Exception
    {
        $user = User::where('email', $credentials)->first();

        if (!$user) {
            throw new Exception(message: json_encode(['email' => ['User not found']]), code: 422);
        }

        if (!Hash::check($password, $user->password)) {
            throw new Exception(message: json_encode(['password' => ['Wrong password']]), code: 422);
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

    public function recovery(array $data): void
    {
        $email = $data['credentials'];

        $token = Str::random(64);

        DB::table('password_reset_tokens')->upsert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ], ['email']);

        $link = url('/recovery-confirm?token=' . $token);

        Mail::to($email)->send(new PasswordRecoveryEmail($link));
    }

    public function verifyToken(string $token): string
    {
        $entry = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$entry) {
            throw new Exception(message: 'Invalid token', code: 400);
        }

        if (Carbon::parse($entry->created_at)->addHour() < Carbon::now()) {
            throw new Exception(message: 'Token has been expired', code: 400);
        }

        $email = $entry->email;

        DB::table('password_reset_tokens')->where('token', $token)->delete();

        return $email;
    }

    public function setNewPassword(array $data): void
    {
        $user = User::where('email', $data['credentials'])->firstOrFail();

        $user->update(['password' => Hash::make($data['password'])]);
    }
}
