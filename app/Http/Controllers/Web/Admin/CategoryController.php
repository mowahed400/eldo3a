<?php

namespace App\Http\Controllers\Web\Admin;

use App\Contracts\CategoryContract;
use App\Contracts\SectionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Content;
use function PHPUnit\Framework\isEmpty;

class CategoryController extends Controller
{
    /**
     * @var CategoryContract
     */
    protected CategoryContract $category;

    /**
     * @var SectionContract
     */
    protected SectionContract $section;

    /**
     * @param CategoryContract $category
     * @param SectionContract $section
     */
    public function __construct(CategoryContract $category, SectionContract $section)
    {
        $this->middleware(['permission:create-category'])->only(['store']);
        $this->middleware(['permission:view-category'])->only(['index','show']);
       // $this->middleware(['permission:view-list-category'])->only(['index']);
        $this->middleware(['permission:edit-category'])->only(['edit','update']);

        $this->category = $category;
        $this->section = $section;
    }

    /**
     * @return Renderable
     */
    public function index() : Renderable
    {
        $categories = $this->category->setRelations(['parent'])->setPerPage(10)->findByFilter();

        return view('admin.categories.index',compact('categories'));
    }

    /**
     * @return Renderable
     */
    public function create() : Renderable
    {
        $sections = $this->section->setRelations(['categories'=>function($query){$query->whereNull('parent_id');}])->setPerPage(0)->findByFilter();

        return view('admin.categories.create',compact('sections'));
    }

    /**
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        $this->category->new($request->validated());
        session()->flash('success',__('messages.flash.create'));
        return redirect()->route('admin.categories.index');
    }

    /**
     * @param $id
     * @return Renderable
     */
    public function show($id): Renderable
    {
        $category = $this->category->findOneById($id);
        return view('admin.categories.show',compact('category'));
    }

    /**
     * @param $id
     * @return Renderable
     */
    public function edit($id): Renderable
    {
        $category = $this->category->setRelations(['section','parent'])->findOneById($id);

        $sections = $this->section->setRelations(['categories'=>function($query){$query->whereNull('parent_id');}])->setPerPage(0)->findByFilter();

        return view('admin.categories.edit',compact('category','sections'));
    }

    /**
     * @param $id
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function update($id,CategoryRequest $request): RedirectResponse
    {
        $this->category->update($id,$request->validated());
        session()->flash('success',__('messages.flash.update'));
        return redirect()->route('admin.categories.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $content = Content::where('category_id',$id)->get();

        if($content->isEmpty()){
            $this->category->destroy($id);
            session()->flash('success',__('messages.flash.delete'));
            return redirect()->route('admin.categories.index');
        }
        return redirect()->route('admin.categories.index');




    }

    public function getCategoriesBySectionId($id,Request $request)
    {
        $categories = $this->category->setPerPage(0)->findBy(['section_id' => $id]);
        if (!$request->wantsJson())
        {
            abort(404);
        }

        return response()->json(compact('categories'));
    }

}
