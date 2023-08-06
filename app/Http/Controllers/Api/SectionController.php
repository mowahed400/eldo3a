<?php

namespace App\Http\Controllers\Api;

use App\Contracts\SectionContract;
use App\Http\Resources\SectionResource;
use Illuminate\Http\Request;

class SectionController extends ApiController
{
    protected SectionContract $section;

    public function __construct(SectionContract $section)
    {
        $this->section = $section;
    }

    public function __invoke(Request $request)
    {
        return SectionResource::collection(
            $this->section->setRelations(['margins'])->setPerPage($request->input('per_page'))
                ->setScopes(['active'])
                ->findByFilter()
        );
    }

}
