<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class StoreRating extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['title' => "string[]", 'description' => "string[]", 'rating' => "string[]"])]
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:100'],
            'description' => ['required'],
            'rating' => ['required', 'numeric', 'between:1,5'],
        ];
    }
}
