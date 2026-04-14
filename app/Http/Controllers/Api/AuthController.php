<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\Services\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}


    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->login($request->validated());
            return (new AuthResource($result))->response()->setStatusCode(200);
        } catch (AuthenticationException $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());
        return (new AuthResource($result))->response()->setStatusCode(201);
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();
        return response()->json(['message' => 'Sesión cerrada correctamente.']);
    }

      public function refresh(): JsonResponse
    {
        $result = $this->authService->refresh();
        return (new AuthResource($result))->response();
    }

    public function me(): JsonResponse
    {
        return response()->json(auth('api')->user());
    }

}
