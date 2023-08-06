<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContentMarginResource extends JsonResource
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
            'content_id' => $this->content_id,
            'margin_id' => $this->margin_id,
            'name' => $this->when(empty($this->getTranslations('name')),'{}',$this->getTranslations('name')),
            'description' => $this->when(empty($this->getTranslations('description')),'{}',$this->getTranslations('description')),
            'margin' => new MarginResource($this->whenLoaded('margin'))
        ];
    }
}
