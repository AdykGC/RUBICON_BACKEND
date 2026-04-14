<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignGoalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['Admin', 'Manager', 'Owner', 'Ceo']);
    }

    public function rules(): array
    {
        return [
            'team_id' => 'required|exists:teams,id',
            'project_id' => 'nullable|exists:projects,id',
            'priority' => 'sometimes|in:low,medium,high,critical',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}