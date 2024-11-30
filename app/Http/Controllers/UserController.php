<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\RegistartionRequest;
use App\Models\UserType;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserTypes()
    {
        return response()->json(UserType::all('id', 'name'));
    }

    public function registration(RegistartionRequest $request, UserService $userService)
    {
        try {
            return response()->json(['token' => $userService->createUser($request->all())]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }

    public function login(Request $request, UserService $userService){
        try {
            return response()->json(['token' => $userService->login($request->get('email'), $request->get('password'))]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function profile(Request $request,UserService $service)
    {
        return response()->json($service->getProfile($request->user()));
    }

    public function changePassword(PasswordRequest $request, UserService $userService)
    {
        try {
            $userService->changePassword($request->user(), $request->get('current_password'), $request->get('new_password'));
            return response()->json(['success' => 'Пароль успешно изменен'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }

    public function updateProfile(ChangeRequest $request, UserService $userService)
    {
        try {
            $userService->updateProfile($request->user(), $request->all());
            return response()->json(['success' => 'Профиль успешно изменен'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function uploadAvatar(Request $request, UserService $userService)
    {
        try {
            $avatar = $userService->uploadAvatar($request->user(), $request->file('avatar'));
            return response()->json(['success' => 'Аватар успешно загружен', 'avatar' => $avatar], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }
}
