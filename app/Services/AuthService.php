<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthService
{
    function login (array $credenciales): array
    {
        $user = User::where('email', $credenciales['email'])->first();

        if (!$user || !$user->active) {
            throw new AuthenticationException('Credenciales inválidas o usuario inactivo.');
        }

        $token = Auth::guard('api')->attempt($credenciales);

        if (!$token) {
            throw new AuthenticationException('Credenciales inválidas.');
        }

        return $this->buildTokenResponse($token, $user);
    }

        public function register(array $data): array
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'] ?? 'trabajador',
        ]);

        $token = auth('api')->login($user);

        return $this->buildTokenResponse($token, $user);
    }

        public function logout(): void
    {
        auth('api')->logout();
    }

    public function refresh(): array
    {
        $token = auth('api')->refresh();
        $user  = auth('api')->user();

        return $this->buildTokenResponse($token, $user);
    }
     private function buildTokenResponse(string $token, User $user): array
    {
        return [
            'token'      => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user'       => $user,
        ];
    }


}
