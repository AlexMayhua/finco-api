<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Auth\RegisterRequest;
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
}
