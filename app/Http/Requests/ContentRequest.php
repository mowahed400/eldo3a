<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class ContentRequest extends FormRequest
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
    #[ArrayShape(['category_id' => "string",'section_id' => "string"])]
    public function rules(): array
    {
        return [
            'section_id' => 'required|integer|exists:sections,id',
            'category_id' => 'sometimes|nullable|integer|exists:categories,id',
        ];
    }
}
