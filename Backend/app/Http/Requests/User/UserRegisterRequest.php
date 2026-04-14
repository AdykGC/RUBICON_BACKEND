<?php namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }
    /** * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> */
    public function rules(): array {
        return [
            'email'             =>  'required|email|unique:users,email',
            'password'          =>  'required|string|min:8|confirmed',
        ];
    }
}
