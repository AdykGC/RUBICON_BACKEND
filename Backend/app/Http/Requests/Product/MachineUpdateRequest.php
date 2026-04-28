<?php namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class MachineUpdateRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }
    /** * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> */
    public function rules(): array {

        return [
            'name' => 'sometimes|string|max:50',
            'type' => 'sometimes|string|max:50',
            'location' => 'sometimes|string|max:100',
            'mac_address' => 'nullable|string|max:50',

            'connection_type' => 'sometimes|nullable|string|max:50',
            'install_price' => 'sometimes|nullable|numeric|min:0',
            'price_adjustment' => 'sometimes|nullable|numeric',
            'latitude' => 'sometimes|nullable|numeric|between:-90,90',
            'longitude' => 'sometimes|nullable|numeric|between:-180,180',
            'is_active' => 'sometimes|boolean',
        ];
    }
}
