<?php

namespace App\Repositories;

use App\Contracts\ProfileRepositoryInterface;
use App\Models\Profile;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function getByUserId(int $userId): ?Profile
    {
        return Profile::where('user_id', $userId)->first();
    }

    public function update(Profile $profile, array $data): Profile
    {
        $profile->fill($data);
        $profile->save();
        return $profile;
    }
}
