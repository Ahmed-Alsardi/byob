<?php

namespace App\Http\Requests;

use App\Models\Chef;
use Illuminate\Foundation\Http\FormRequest;

class UpdateChefRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(Chef $chef): array
    {
        return [
            "name" => "nullable",
            "email" => "nullable|email|unique:users,email," . $chef->id
        ];
    }
}
