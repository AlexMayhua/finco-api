<?php

namespace App\Services;

use App\Contracts\ProfileServiceInterface;
use App\Contracts\ProfileRepositoryInterface;
use App\Models\User;
use App\Models\Profile;

class ProfileService implements ProfileServiceInterface
{
    public function __construct(private readonly ProfileRepositoryInterface $profiles) {}

    public function me(User $user): Profile
    {
        $profile = $this->profiles->getByUserId($user->id);
        if (!$profile) {
            $profile = new Profile(['user_id' => $user->id]);
            $profile->save();
        }
        return $profile;
    }

    public function update(User $user, array $payload): Profile
    {
        $profile = $this->profiles->getByUserId($user->id);
        if (!$profile) {
            $profile = new Profile(['user_id' => $user->id]);
            $profile->save();
        }

        return $this->profiles->update($profile, $payload);
    }
}
