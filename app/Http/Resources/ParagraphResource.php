<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class ParagraphResource extends JsonResource
{




    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */


    public function toArray($request)
    {

        $pargraphKeywords = DB::table('paragraph_keywords')->where('paragraph_id',$this->id)->get();

        $keywords = Array();

        for($i = 0;$i<count($pargraphKeywords);$i++){
            $keywords[$i] = DB::table('section_keywords')->where('id',$pargraphKeywords[$i]->section_keyword_id)->get('keyword');
    }

        return [
            'id' => $this->id,
            'text' => $this->when(empty($this->getTranslations('text')),'{}',$this->getTranslations('text')),
            'start_from' => $this->when(empty($this->getTranslations('start_from')),'{}',$this->getTranslations('start_from')),
            'end_at' => $this->when(empty($this->getTranslations('end_at')),'{}',$this->getTranslations('end_at')),
            'content_id' => $this->content_id,
            'keywords' => $keywords
        ];
    }
}
