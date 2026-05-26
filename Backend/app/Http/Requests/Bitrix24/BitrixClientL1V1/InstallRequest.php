<?php

namespace App\Http\Requests\Bitrix24\BitrixClientL1V1;

use Illuminate\Foundation\Http\FormRequest;

class InstallRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'member_id' => ['required', 'string'],
            'DOMAIN' => ['required', 'string'],
            'AUTH_ID' => ['required', 'string'],
            'REFRESH_ID' => ['nullable', 'string'],
            'AUTH_EXPIRES' => ['nullable', 'integer'],
            'APPLICATION_TOKEN' => ['nullable', 'string'],
            'APPLICATION_SCOPE' => ['nullable', 'string'],
            'SERVER_ENDPOINT' => ['nullable', 'string'],
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
