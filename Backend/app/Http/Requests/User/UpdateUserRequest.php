<?php namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }
    /** * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> */
    public function rules(): array {
        return [
            'name'              =>  'sometimes|string|max:50',
            'company_title'     =>  'sometimes|string|max:50',
            'phone'             =>  'sometimes|string|max:25',
            'address'           =>  'sometimes|string|max:50',
            // 'role'              =>  'sometimes|string|in:Owner,Client',
        ];
    }
}
