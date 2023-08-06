<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarginRequest extends FormRequest
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
        ];

        foreach (getLangs() as $lang => $config)
        {
            if ($lang === 'ar')
            {
                $rules['name.'.$lang] = 'required|string|max:200';
            }else{
                $rules['name.'.$lang] = 'sometimes|nullable|string|max:200';
            }
        }

        return  $rules;
    }
}
