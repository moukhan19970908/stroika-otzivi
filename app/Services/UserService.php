<?php

namespace App\Services;

use App\Models\CodeVerification;
use App\Models\MasterComment;
use App\Models\Post;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserService
{
    public function createUser($data)
    {
        DB::beginTransaction();
        $exist = User::where('phone',$data['phone'])->first();
        if ($exist && $exist->verified){
            throw new \Exception('Ваш телефон уже зарегистрирован');
        }
        if (!$exist) {
            $data = [
                'fio' => $data['fio'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'user_type_id' => $data['user_type_id'],  // 1 - master, 2 - rieltor, 3 - client,
                'experience' => $data['experience'] ?? false,
                'phone' => $data['phone'],
            ];
            $user = User::create($data);

            if (!$user) {
                DB::rollBack();
                throw new \Exception('Произошла ошибка при создании пользователя');
            }
        }
        $code = rand(1000, 9999);
        $send = $this->sendMesssage($code, $data['phone']);

        if (!$send) {
            DB::rollBack();
            throw new \Exception('Не удалось отправить смс');
        }
        DB::commit();
        return 'На ваш телефон отправлен код';
    }

    public function verify($code, $phone)
    {
        $search = CodeVerification::where('code', $code)->where('phone', $phone)->orderByDesc('id')->first();
        if (!$search) {
            throw new \Exception('Код не найден');
        }
        $user = User::where('phone', $phone)->first();
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

        $user->verified = true;
        $user->save();

        return $token;
    }

    public function sendMesssage($code, $phone)
    {
        $message = "Ваш код подтверждения: $code";
        $url = env('SMS_SEND_URL') . '?number=' . $phone . '&text=' . $message . '&sign=SMS Aero';
        $client = new Client(['verify' => false]);
        try {
            $response = $client->get($url);
            $response = $response->getBody()->getContents();
            $response = json_decode($response,true);
            Log::info('Response from', ['resp' => $response]);
            if (isset($response) && $response['success']){
                CodeVerification::create([
                    'phone' => $phone,
                    'code' => $code,
                ]);
                return true;
            } else {
                throw new \Exception('Ошибка при отправке смс');
            }
        } catch (\Exception $e) {
            throw new \Exception('Ошибка при отправке смс');
        }

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
            return [
                'user' => $user,
                'post' => Post::with(['images', 'masterComments.user', 'rieltorComments.user'])->where('user_id', $user->id)->get(),
            ];

        }
        return [
            'user' => $user,
        ];
    }

    public function updateProfile($user, $data)
    {
        $anyUser = User::where('id', '!=', $user->id)->where('email', $data['email'])->first();
        if ($anyUser) {
            throw new \Exception('Такой email уже занят');
        }
        try {
            $user->fio = $data['fio'];
            $user->email = $data['email'];
            $user->phone = $data['phone'];
            $user->save();
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function uploadAvatar($user, $file)
    {
        $path = $file->store('avatars', 'public');
        $user->avatar = '/storage/' . $path;
        $user->save();
        return $path;
    }

    public function login($email, $password)
    {
        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            throw new \Exception('Неверный email или пароль');
        }
        if (!$user->verified){
            throw new \Exception('Ваш телефон не верифицирован');
        }
        $abilities = [
            1 => 'master',
            2 => 'rieltor',
            3 => 'client',
        ];
        return $user->createToken('api', [$abilities[$user->user_type_id]])->plainTextToken;
    }
}

