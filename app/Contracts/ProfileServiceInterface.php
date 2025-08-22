<?php

namespace App\Contracts;

use App\Models\Profile;
use App\Models\User;

interface ProfileServiceInterface
{
    public function me(User $user): Profile;
    public function update(User $user, array $payload): Profile;
}
