<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contracts\ProfileServiceInterface;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Support\ApiResponse;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct(private readonly ProfileServiceInterface $profileService) {}

    public function me(Request $request): JsonResponse
    {
        $profile = $this->profileService->me($request->user());
        $data = $profile->toArray();
        if ($profile->profile_photo) {
            $data['profile_photo_url'] = Storage::url($profile->profile_photo);
        }
        return ApiResponse::success($data, 'Perfil');
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $profile = $this->profileService->update($request->user(), $request->validated());
        $data = $profile->toArray();
        if ($profile->profile_photo) {
            $data['profile_photo_url'] = Storage::url($profile->profile_photo);
        }
        return ApiResponse::success($data, 'Perfil actualizado');
    }
}
