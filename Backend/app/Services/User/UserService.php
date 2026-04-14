<?php namespace App\Services\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Collection;
use Illuminate\Database\Seeder\RoleSeeder;
use Spatie\Permission\Models\Permission;
use App\Models\{
    User,
};


class UserService {
    public function register($request){
        try {
            $data = User::create([ 'email' => $request->email, 'password' => Hash::make($request->password), ]);
            $token = $data->createToken('Token')->plainTextToken;
            return [
                'token' => $token,
                'user' => $data, 
            ];
        } catch (\Exception $e) {
            throw new \Exception('Ошибка при создании пользователя: ' . $e->getMessage());
        }
    }


    public function login($request){
        $data = User::where('email', $request->email)->first();

        if (!$data || !Hash::check($request->password, $data->password)) {
            throw new \Exception('Неверный email или пароль');
        }
        if (!$data->is_active) {
            throw new \Exception('Аккаунт деактивирован');
        }

        $token = $data->createToken('Token')->plainTextToken;

        return [
            'token' => $token,
            'user' => [
                'id' => $data->id,
                'name' => $data->name,
                'surname' => $data->surname,
                'email' => $data->email,
            ],
        ];
    }


    public function read($user) {
        return response()->json([
            'user' => $user,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'is_active' => $user->is_active,
        ]);
    }


    public function update($request, $user){
        $validatedData = $request->validated();
        if (empty($validatedData)) {
            return response()->json([ 'message' => 'Нет данных для обновления.' ], 422);
        }

        // Обновляем роль если она передана
        if (isset($validatedData['role'])) {
            $user->syncRoles([$validatedData['role']]);
            unset($validatedData['role']);
        }
    
        // Обновляем остальные данные и загружаем свежие данные
        $user->update($validatedData);
        $user->load('roles');

        return response()->json([
            'message' => 'Профиль успешно обновлён',
            'user' => $user->makeHidden(['roles', 'permissions']),
            'role' => $user->getRoleNames()->first(),
            'permissions' => $user->getAllPermissions()->pluck('name')
        ]);
    }


    public function logout(){
        return response()->json([
            'status' => 'success',
            'message' => 'Вы вышли из системы',
        ]);
    }
}