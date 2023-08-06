<?php

namespace App\Http\Controllers\Web\Admin;

use App\Contracts\ContentMarginContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContentMarginsRequest;
use Illuminate\Http\Request;

class ContentMarginController extends Controller
{
    protected ContentMarginContract $margin_content;

    public function __construct(ContentMarginContract $margin_content)
    {
        $this->margin_content = $margin_content;
    }

    public function index($content_id,$margin_id,Request $request)
    {
        $margins = $this->margin_content->findBy([
            'content_id' =>  $content_id,
            'margin_id' => $margin_id
        ]);

        if (!$request->wantsJson())
        {
            abort(404);
        }

        return response()->json(compact('margins'));

    }

    public function store($content_id,$margin_id,ContentMarginsRequest $request)
    {
        $data = $request->validated();
        $data['content_id'] = $content_id;
        $data['margin_id'] = $margin_id;

        $margin = $this->margin_content->new($data);
        return response()->json([
            'success' => true,
            'message' => __('messages.flash.create'),
            'margin' => $margin
        ],201);
    }

    public function update($id,ContentMarginsRequest $request)
    {
        $data = $request->validated();

        $margin = $this->margin_content->update($id,$data);
        return response()->json([
            'success' => true,
            'message' => __('messages.flash.update'),
            'margin' => $margin
        ],201);
    }

    public function destroy($id)
    {
        $this->margin_content->destroy($id);
        return response()->json([
            'success' => true,
            'message' => __('messages.flash.delete'),
        ]);
    }
}
