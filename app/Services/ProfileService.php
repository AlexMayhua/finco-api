<?php

namespace App\Services;

use App\Contracts\ProfileServiceInterface;
use App\Contracts\ProfileRepositoryInterface;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;

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

        if (isset($payload['profile_photo_file']) && $payload['profile_photo_file']) {
            $file = $payload['profile_photo_file'];
            $path = $file->store('profile_photos', 'public');
            $payload['profile_photo'] = $path;
            unset($payload['profile_photo_file']);
        }

        return $this->profiles->update($profile, $payload);
    }
}
