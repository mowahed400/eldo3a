<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'section_id' => $this->section_id,
            'name' => $this->getTranslations('name'),
            'description' => $this->getTranslations('description'),
            'image_url' => $this->image_url,
            'color' => $this->color,
            'type' => $this->type,
            'children' => self::collection($this->whenLoaded('children')),
        ];
    }
}
