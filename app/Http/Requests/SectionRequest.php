<?php

namespace App\Http\Requests;

use App\Enums\SectionState;
use App\Enums\SectionType;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class SectionRequest extends FormRequest
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
    #[ArrayShape(['name' => "string", 'description' => "string", 'color' => "string", 'state' => "string", 4 => "string", 'image' => "string"])]
    public function rules(): array
    {

        $rules =  [
            'name'          => 'required|array|min:1',
            'description'   => 'required|array|min:1',
            //'color'         => 'sometimes|nullable|string|max:20',
            'state'         => 'required|integer|in:'.implode(',',SectionState::values()),
            'type'         => 'required|integer|in:'.implode(',',SectionType::values()),
            'image'         => 'sometimes|nullable|file|image:'.settings('image_size'),
            'settings'         => 'required|array',
            'settings.has_margins' => 'required|integer|in:'.implode(',',SectionState::values()),
        ];

        foreach (getLangs() as $lang => $config)
        {
            if ($lang === 'ar')
            {
                $rules['name.'.$lang] = 'required|string|max:200';
                $rules['description.'.$lang] = 'required|nullable|string|max:300';
            }

            $rules['name.'.$lang] = 'required|nullable|string|max:200';
            $rules['description.'.$lang] = 'required|nullable|string|max:300';
        }

        return $rules;
    }
}
