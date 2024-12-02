<?php

namespace App\Services;

use App\Models\MasterComment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserService
{
    public function createUser($data)
    {
        $data = [
            'fio' => $data['fio'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type_id' => $data['user_type_id'],  // 1 - master, 2 - rieltor, 3 - client,
            'experience' => $data['experience'] ?? false,
            'phone' => $data['phone'],
        ];
        $user = User::create($data);
        $token = '';
        if ($user->user_type_id == 1) {
            $token = $user->createToken('api', ['master'])->plainTextToken;
        } else if ($user->user_type_id == 2) {
            $token = $user->createToken('api', ['rieltor'])->plainTextToken;
        } else if ($user->user_type_id == 3) {
            $token = $user->createToken('api', ['client'])->plainTextToken;
        }

        if (!$token) {
            throw new \Exception('Попробуйте позже');
        }

        return $token;
    }

    public function changePassword($user, $currentPassword, $newPassword)
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw new \Exception('Невернный пароль');
        }
        $user->password = Hash::make($newPassword);
        $user->save();
        return true;
    }

    public function getProfile(User $user)
    {
        if ($user->user_type_id == 3) {
            $posts = Post::where('user_id', $user->id)->pluck('id')->toArray();
            return [
                'user' => $user,
                'post' => Post::with(['images','masterComments.user','rieltorComments.user'])->where('user_id', $user->id)->get(),
            ];

        }
        return [
            'user' => $user,
        ];
    }

    public function updateProfile($user, $data)
    {
        $anyUser = User::where('id', '!=', $user->id)->where('email',$data['email'])->first();
        if ($anyUser){
            throw new \Exception('Такой email уже занят');
        }
        try{
            $user->fio = $data['fio'];
            $user->email = $data['email'];
            $user->phone = $data['phone'];
            $user->save();
            return true;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function uploadAvatar($user, $file)
    {
        $path = $file->store('avatars', 'public');
        $user->avatar = env('APP_URL') . '/storage/' . $path;
        $user->save();
        return $path;
    }

    public function login($email, $password)
    {
        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            throw new \Exception('Неверный email или пароль');
        }
        $abilities = [
            1 => 'master',
            2 => 'rieltor',
            3 => 'client',
        ];
        return $user->createToken('api', [$abilities[$user->user_type_id]])->plainTextToken;
    }
}

