<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Contracts\AuthServiceInterface;

class AuthController extends Controller
{
	public function __construct(private readonly AuthServiceInterface $authService) {}

	public function register(RegisterRequest $request): JsonResponse
	{
		return response()->json(
			$this->authService->register($request->validated()),
			201
		);
	}

	public function login(LoginRequest $request): JsonResponse
	{
		return response()->json(
			$this->authService->login($request->validated())
		);
	}

	public function logout(LogoutRequest $request): JsonResponse
	{
		$data = $request->validated();
		$allDevices = (bool)($data['all_devices'] ?? false);
		return response()->json(
			$this->authService->logout($request->user(), $allDevices)
		);
	}
}
