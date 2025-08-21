<?php

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    public function __construct(private readonly UserRepositoryInterface $users) {}

    public function register(array $payload): array
    {
        $user = $this->users->create([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password' => Hash::make($payload['password']),
        ]);

        if (method_exists($user, 'profile')) {
            $user->profile()->create([]);
        }

        $token = $user->createToken('android')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ];
    }

    public function login(array $credentials): array
    {
        $user = $this->users->findByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciales inválidas.'],
            ]);
        }

        $token = $user->createToken('android')->plainTextToken;

        return [
            'user' => $user->load('profile'),
            'token' => $token,
            'token_type' => 'Bearer',
        ];
    }
}
