<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentMarginsRequest extends FormRequest
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
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|array|min:1',
            'description' => 'sometimes|nullable|array',
        ];

        foreach (getLangs() as $lang => $config)
        {
            if ($lang === 'ar')
            {
                $rules['name.'.$lang] = 'required|string|max:200';
            }else{
                $rules['name.'.$lang] = 'sometimes|nullable|string|max:200';
            }
            $rules['description.'.$lang] = 'sometimes|nullable|string';

        }


        return  $rules;
    }
}
