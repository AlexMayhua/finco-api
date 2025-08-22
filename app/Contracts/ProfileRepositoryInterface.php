<?php

namespace App\Contracts;

use App\Models\Profile;

interface ProfileRepositoryInterface
{
    public function getByUserId(int $userId): ?Profile;
    public function update(Profile $profile, array $data): Profile;
}
