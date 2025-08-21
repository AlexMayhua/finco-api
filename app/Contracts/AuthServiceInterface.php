<?php

namespace App\Contracts;

use App\Models\User;

interface AuthServiceInterface
{
    public function register(array $payload): array;
}
