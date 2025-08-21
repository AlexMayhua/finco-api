<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contracts\ProfileServiceInterface;
use App\Http\Requests\Profile\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function __construct(private readonly ProfileServiceInterface $profileService) {}

    public function me(Request $request): JsonResponse
    {
        $profile = $this->profileService->me($request->user());
        return response()->json($profile);
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $profile = $this->profileService->update($request->user(), $request->validated());
        return response()->json($profile);
    }
}
