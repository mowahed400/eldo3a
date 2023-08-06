<?php

namespace App\Http\Controllers\Api;

use App\Contracts\CategoryContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryContract $category;

    public function __construct(CategoryContract $category)
    {
        $this->category = $category;
    }

    public function __invoke(Request $request)
    {
        $categories = $this->category->setScopes(['active'])
            ->setRelations(['children' => function($query){
                $query->active();
            }])
            ->setPerPage($request->input('per_page'))
            ->findByFilter();
        return CategoryResource::collection($categories);
    }
}
