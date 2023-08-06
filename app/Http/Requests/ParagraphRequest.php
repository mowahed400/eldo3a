<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParagraphRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws \JsonException
     */
    public function rules()
    {
        $rules =  [
            //'text' => 'required|array',
            'start_from' => 'sometimes|nullable|array',
            'end_at' => 'sometimes|nullable|array',
            'keywords'=>'sometimes|nullable|array'
        ];

        foreach (getLangs() as $lang => $config)
        {
            $rules['end_at.'.$lang] = 'sometimes|nullable|string|date_format:H:i:s';
            $rules['start_from.'.$lang] = 'sometimes|nullable|string|date_format:H:i:s';
            //$rules['text.'.$lang] = 'sometimes|nullable|string';
        }

        return $rules;
    }
}
