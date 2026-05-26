<?php namespace App\Http\Requests\Bitrix24\BitrixClientL1V1;

use Illuminate\Foundation\Http\FormRequest;

class UninstallRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'member_id' => ['required', 'string'],
        ];
    }

    public function prepareForValidation(): void
    {
        // нормализуем в одно поле
        $this->merge([
            'member_id' => $this->input('member_id') ?: $this->input('MEMBER_ID'),
        ]);
    }
}