<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    /**
     * Login user
     *
     * @param Request $request
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
     *
     * @param Request $request
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
}
