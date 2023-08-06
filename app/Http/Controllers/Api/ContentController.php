<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ContentContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContentResource;
use Illuminate\Http\Request;

class ContentController extends ApiController
{
    protected  ContentContract $content;

    public function __construct(ContentContract $content)
    {
        $this->content = $content;
    }

    public function index()
    {
        $contents = $this->content->setPerPage(0)->setRelations(['paragraphs','margins.margin'])->findByFilter();
        return ContentResource::collection($contents);
    }

    public function show($category_id)
    {
        $content = $this->content->setRelations(['paragraphs','margins.margin'])->findOneBy(['category_id'=>$category_id]);

        return new ContentResource($content);
    }

    public function showBySection($section_id)
    {
        $content = $this->content->setRelations(['paragraphs','margins.margin'])->findOneBy(['section_id'=>$section_id]);
        return new ContentResource($content);
    }


}
