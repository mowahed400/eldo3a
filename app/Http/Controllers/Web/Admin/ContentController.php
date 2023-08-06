<?php

namespace App\Http\Controllers\Web\Admin;

use App\Contracts\CategoryContract;
use App\Contracts\ContentContract;
use App\Contracts\SectionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContentRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    protected ContentContract $content;
    protected CategoryContract $category;
    protected SectionContract $section;

    public function __construct(ContentContract $content,CategoryContract $category,SectionContract $section)
    {
        $this->content = $content;
        $this->category = $category;
        $this->section = $section;

        //$this->middleware(['permission:view-list-content'])->only(['index']);
        $this->middleware(['permission:view-content'])->only(['index','show']);
        $this->middleware(['permission:edit-content'])->only(['edit', 'update']);
        $this->middleware(['permission:create-content'])->only(['create', 'store']);
        $this->middleware(['permission:delete-content'])->only(['destroy']);
    }

    public function index() : Renderable
    {
        $contents = $this->content->findByFilter();

        return view('admin.contents.index',compact('contents'));
    }

    public function create() : Renderable
    {
        $categories = $this->category
            //->setScopes(['childCategories'])
            ->setPerPage(0)->findByFilter();
        $sections = $this->section->setRelations(['categories'=>function($query){$query->whereNull('parent_id');}])->setPerPage(0)->findByFilter();

        return view('admin.contents.create',compact('categories','sections'));
    }

    public function store(ContentRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->content->new($request->validated());
        session()->flash('success',__('messages.flash.create'));
        return redirect()->route('admin.contents.index');
    }

    public function show($id, Request $request)
    {
        $content = $this->content->findOneById($id);
        if($request->wantsJson())
        {
            $categories = $content->categories()->whereNull('parent_id')->get();
            return response()->json(compact('categories'));
        }
        $titles = $this->getJoumals($content->paragraphs);

        return view('admin.contents.show',compact('content','titles'));
    }

    public function edit($id): Renderable
    {
        $categories = $this->category
            //->setScopes(['childCategories'])
        ->setPerPage(0)->findByFilter();
        $sections = $this->section->setRelations(['categories'=>function($query){$query->whereNull('parent_id');}])->setPerPage(0)->findByFilter();

        $content = $this->content->findOneById($id);
        return view('admin.contents.edit',compact('content','categories','sections'));
    }

    public function update($id,ContentRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->content->update($id,$request->validated());
        session()->flash('success',__('messages.flash.update'));
        return redirect()->route('admin.contents.index');
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $this->content->destroy($id);
        session()->flash('success',__('messages.flash.delete'));
        return redirect()->route('admin.contents.index');
    }

    public function upload($id,$type,Request $request)
    {
        $data = $request->validate([
            'voice' => 'required|file|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav'
        ]);

        $data['type'] = $type;

        $content = $this->content->uploadVoice($id,$data);

        return response()->json(compact('content'));
    }

    public function removeFile($id,$type)
    {
        $content = $this->content->removeVoice($id,$type);
        return response()->json(compact('content'));
    }

    public function marginsIndex($id)
    {
        $content = $this->content->setRelations(['section.margins','margins'])->findOneById($id);
        return view('admin.contents.margins.index',compact('content'));
    }

    public function getJoumals($paragraphs){
        $decodedParagraphsText = [];
        $titlesArray = [];

        for ($i=0;$i<count($paragraphs);$i++){

            $decodedParagraphsText[$i] = json_decode($paragraphs[$i]->text);

            if($decodedParagraphsText[$i]!=null){

                if($decodedParagraphsText[$i]->blocks != null){

                    for ($j=0;$j<3;$j++) {

                        if(count($decodedParagraphsText[$i]->blocks)>$j){
                            if(isset( $decodedParagraphsText[$i]->blocks[$j]->data->text)){
                                $titlesArray[$i]['title no_ '.$j] = $decodedParagraphsText[$i]->blocks[$j]->data->text;
                            }
                            else if(isset( $decodedParagraphsText[$i]->blocks[$j]->data->ayatText)){
                                $titlesArray[$i]['title no_ '.$j] = $decodedParagraphsText[$i]->blocks[$j]->data->ayatText;
                            }
                            else{
                                $titlesArray[$i]['title no_ '.$j] = '';
                            }
                        }else{
                            $titlesArray[$i]['title no_ '.$j] ='';
                        }

                    }

                }

                else{
                    for($k=0;$k<3;$k++){
                        $titlesArray[$i]['title no_ '.$k] = ' لا يوجد جمل ';
                    }
                }

            }

            else{
                for($k=0;$k<3;$k++){
                    $titlesArray[$i]['title no_ '.$k] = 'لا يوجد جمل  ';
                }

            }

        }
        return $titlesArray;
    }


}
