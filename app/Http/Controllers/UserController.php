<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\RegistartionRequest;
use App\Http\Requests\VerificationRequest;
use App\Models\UserType;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getUserTypes()
    {
        return response()->json(UserType::all('id', 'name'));
    }

    public function registration(RegistartionRequest $request)
    {
        try {
            return response()->json(['message' => $this->userService->createUser($request->all())]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function verify(VerificationRequest $request)
    {
        try {
            return response()->json(['success' => 'Аккаунт верифицирован', 'token' => $this->userService->verify($request->code,$request->phone)], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            return response()->json(['token' => $this->userService->login($request->get('email'), $request->get('password'))]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function profile(Request $request)
    {
        return response()->json($this->userService->getProfile($request->user()));
    }

    public function changePassword(PasswordRequest $request)
    {
        try {
            $this->userService->changePassword($request->user(), $request->get('current_password'), $request->get('new_password'));
            return response()->json(['success' => 'Пароль успешно изменен'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }

    public function updateProfile(ChangeRequest $request)
    {
        try {
            $this->userService->updateProfile($request->user(), $request->all());
            return response()->json(['success' => 'Профиль успешно изменен'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function uploadAvatar(Request $request)
    {
        try {
            $avatar = $this->userService->uploadAvatar($request->user(), $request->file('avatar'));
            return response()->json(['success' => 'Аватар успешно загружен', 'avatar' => $avatar], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }


}
