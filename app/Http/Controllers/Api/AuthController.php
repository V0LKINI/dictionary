<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RecoveryRequest;
use App\Http\Requests\RecoverySetRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    /**
     * Login user
     */
    public function login(LoginRequest $request)
    {
        try {
            $user = $this->authService->login($request->credentials, $request->password);

            $response = [
                'token' => $user->getAttribute('new_token'),
                'user' => UserResource::make($user),
            ];

            return $this->success($response);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Register user
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authService->register($request->validated());

            $response = [
                'token' => $user->getAttribute('new_token'),
                'user' => UserResource::make($user),
            ];

            return $this->success($response);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Request a recovery password email
     */
    public function recovery(RecoveryRequest $request)
    {
        try {
            $this->authService->recovery($request->validated());

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Verify password recovery token
     */
    public function verifyToken(string $token)
    {
        try {
            $email = $this->authService->verifyToken($token);

            return $this->success(['email' => $email]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Set new password for user
     */
    public function setNewPassword(RecoverySetRequest $request)
    {
        try {
            $this->authService->setNewPassword($request->validated());

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
