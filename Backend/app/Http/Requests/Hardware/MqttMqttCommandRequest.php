<?php namespace App\Http\Requests\Hardware;

use Illuminate\Foundation\Http\FormRequest;

class MqttMqttCommandRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }
    /** * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> */
    public function rules(): array {
        return [
            'mac' => 'required|string',
            'pulses' => 'required|integer|min:1',
        ];
    }
}
