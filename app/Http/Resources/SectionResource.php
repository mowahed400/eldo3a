<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
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
            'name' => $this->getTranslations('name'),
            'description' => $this->getTranslations('description'),
            'image_url' => $this->image_url,
            'type' => $this->type,
            'margins' => MarginResource::collection($this->whenLoaded('margins')),
            'settings' => array_map(function ($item){
                return (int)$item;
            },$this->settings ?? [])
            //'color' => $this->color,
        ];
    }
}
