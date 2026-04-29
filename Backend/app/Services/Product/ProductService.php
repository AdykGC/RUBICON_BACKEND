<?php namespace App\Services\Product;

use Illuminate\Support\Facades\Hash;
use App\Models\{
    Machine,
};


class ProductService {
    public function create($request){
        try {
            $data = Machine::create([ 'name' => $request->name, 'type' => $request->type, 'location' => $request->location, 'mac_address' => $request->mac_address, 'user_id' => auth()->id(),]);
            return [
                'machine' => $data,
            ];
        } catch (\Exception $e) {
            throw new \Exception('Ошибка при создании машины: ' . $e->getMessage());
        }
    }

        /* ================= LIST ================= */
    public function index() {
        try {
            $machines = Machine::where('user_id', auth()->id())->get();
            return [
                'machine' => $machines,
            ];
        } catch (\Exception $e) {
            throw new \Exception('Ошибка при получении списка: ' . $e->getMessage());
        }
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