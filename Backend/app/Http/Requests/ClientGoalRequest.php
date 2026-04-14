<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientGoalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
        // Клиент может создавать цели только для себя
        // $user = $this->user();
        // return $user && $user->hasAnyRole(['Client', 'Client VIP']);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:business,personal,project,other',
            'target_value' => 'required|numeric|min:0',
            'unit' => 'required|string|max:20',
            'deadline' => 'required|date|after:today',
            'priority' => 'required|in:low,medium,high,critical',
            'expected_budget' => 'nullable|numeric|min:0',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Название цели обязательно',
            'deadline.after' => 'Срок выполнения должен быть в будущем',
        ];
    }
}