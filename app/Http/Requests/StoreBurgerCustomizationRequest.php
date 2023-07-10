<?php

namespace App\Http\Requests;

use App\Repository\BurgerCustomizationRepository;
use Illuminate\Foundation\Http\FormRequest;

class StoreBurgerCustomizationRequest extends FormRequest
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
    public function rules(): array
    {
        $meat = BurgerCustomizationRepository::MEAT;
        $bread = BurgerCustomizationRepository::BREAD;
        $side = BurgerCustomizationRepository::SIDE;
        return [
            "category" => "required|string|in:{$meat},{$bread},{$side}",
            "name" => "required|string|min:2|max:255",
        ];
    }
}
