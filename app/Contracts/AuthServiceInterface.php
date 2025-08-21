<?php

namespace App\Contracts;

use App\Models\User;

interface AuthServiceInterface
{
    public function register(array $payload): array;
    public function login(array $credentials): array;
}
