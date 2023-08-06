<?php

namespace App\Http\Requests;

use App\Enums\CategoryState;
use App\Enums\CategoryType;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name'          => 'required|array|min:1',
            'description'   => 'required|array|min:1',
            'color'         => 'sometimes|nullable|string|max:20',
            'state'         => 'required|integer|in:'.implode(',',CategoryState::values()),
            'image'         => 'sometimes|nullable|file|image:'.settings('image_size'),
            'section_id'    => 'required|integer|exists:sections,id',
            'parent_id'     => 'sometimes|nullable|integer|exists:categories,id',
            'type'         => 'required|integer|in:'.implode(',',CategoryType::values()),

        ];

        foreach (getLangs() as $lang => $config)
        {

            if ($lang === 'ar')
            {
                $rules['name.'.$lang] = 'required|string|max:200';
                $rules['description.'.$lang] = 'required|string|max:300';
            }

            $rules['name.'.$lang] = 'sometimes|nullable|string|max:200';
            $rules['description.'.$lang] = 'sometimes|nullable|string|max:300';
        }

        return $rules;
    }
}
