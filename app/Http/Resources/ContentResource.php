<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
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
            'voice_url' => $this->voice_url,
            'category_id' => $this->category_id,
            'section_id' => $this->section_id,
            'content_margins' => ContentMarginResource::collection($this->whenLoaded('margins')),
            'paragraphs' => ParagraphResource::collection($this->whenLoaded('paragraphs'))
        ];
    }
}
