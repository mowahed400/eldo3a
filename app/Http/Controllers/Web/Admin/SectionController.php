<?php

namespace App\Http\Controllers\Web\Admin;

use App\Contracts\SectionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Models\Content;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    protected SectionContract $section;

    public function __construct(SectionContract $section)
    {
        $this->section = $section;

        //$this->middleware(['permission:view-list-section'])->only(['index']);
        $this->middleware(['permission:view-section'])->only(['index','show']);
        $this->middleware(['permission:edit-section'])->only(['edit', 'update']);
        $this->middleware(['permission:create-section'])->only(['create', 'store']);
        $this->middleware(['permission:delete-section'])->only(['destroy']);
    }

    public function index() : Renderable
    {
        $sections = $this->section->findByFilter();

        return view('admin.sections.index',compact('sections'));
    }

    public function create() : Renderable
    {
        return view('admin.sections.create');
    }

    public function store(SectionRequest $request)//: \Illuminate\Http\RedirectResponse
    {

        $storeSection = $this->section->new($request->validated());
        if($storeSection == false){
            session()->flash('error',__('messages.flash.cant_add_duplicate'));
            return redirect()->route('admin.sections.index');
        }
        session()->flash('success',__('messages.flash.create'));
        return redirect()->route('admin.sections.index');
    }

    public function show($id, Request $request)
    {
        $section = $this->section->findOneById($id);
        if($request->wantsJson())
        {
            $categories = $section->categories()->whereNull('parent_id')->get();
            return response()->json(compact('categories'));
        }

        return view('admin.sections.show',compact('section'));
    }

    public function edit($id): Renderable
    {
        $section = $this->section->findOneById($id);
        return view('admin.sections.edit',compact('section'));
    }

    public function update($id,SectionRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->section->update($id,$request->validated());
        session()->flash('success',__('messages.flash.update'));
        return redirect()->route('admin.sections.index');
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $content = Content::where('section_id',$id)->get();

        if($content->isEmpty()){
            $this->section->destroy($id);
            session()->flash('success',__('messages.flash.delete'));
            return redirect()->route('admin.sections.index');
        }
        return redirect()->route('admin.sections.index');



    }

}
