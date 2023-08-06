<?php

namespace App\Http\Controllers\Web\Admin;

use App\Contracts\ContentContract;
use App\Contracts\ParagraphContract;
use App\Contracts\SectionKeywordContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\ParagraphRequest;
use App\Models\Content;
use App\Models\ParagraphKeyword;
use App\Models\Section;
use App\Models\SectionKeyword;
use Illuminate\Http\Request;
use App\Models\Paragraph;
use PhpParser\Node\Expr\Array_;

class ParagraphController extends Controller
{
    protected ParagraphContract $paragraph;
    protected ContentContract $content;

    public function __construct(ParagraphContract $p,ContentContract $content)
    {
        $this->paragraph = $p;
        $this->content = $content;

    }

    public function index()
    {
        $paragraphs = Paragraph::all();

        $titlesArray = $this->getJoumals($paragraphs);

       return view('admin.contents.paragraphs.index')->with('paragraphs',$paragraphs)->with('titles',$titlesArray);

    }

    public function create($content_id)
    {
        $content = $this->content->findOneById($content_id);
        return view('admin.contents.paragraphs.create',compact('content'));
    }

    public function store($content_id,ParagraphRequest $request)
    {
        $data = $request->validated();
        $content = $this->content->findOneById($content_id);
        $data['content_id'] = $content->id;
        $this->paragraph->new($data);
        session()->flash('success',__('messages.flash.create'));

        return to_route('admin.contents.show',$content_id);
    }

    public function edit($content_id,$paragraph_id)
    {
        $paragraph = $this->paragraph->findOneBy(['content_id'=>$content_id,'id'=>$paragraph_id]);
        $sectionId = Content::where('id',$content_id)->first('section_id');


        //Retrieve Keywords
        $sectionKeywords = SectionKeyword::where('section_id',$sectionId->section_id)->get(['id','keyword']);
        $paragraphKeywords = ParagraphKeyword::where('paragraph_id',$paragraph_id)->get();
        //return($paragraphKeywords);
        $paragraphKeywordsArray = [];
        for ($i = 0;$i<count($paragraphKeywords);$i++){
            $paragraphKeywordsArray[$i] =  $paragraphKeywords[$i]['section_keyword_id'];
        }

        return view('admin.contents.paragraphs.edit',compact('paragraph','sectionKeywords','paragraphKeywordsArray'));
    }

    public function update($content_id,$paragraph_id,ParagraphRequest $request)
    {


        $data = $request->validated();

        $paragraph = $this->paragraph->findOneBy(['content_id'=>$content_id,'id'=>$paragraph_id]);
        $this->paragraph->update($paragraph,$data);



        session()->flash('success',__('messages.flash.update'));
        return to_route('admin.contents.show',$content_id);
    }

    public function show($content_id,$paragraph_id)
    {
        $paragraph = $this->paragraph->findOneBy(['content_id'=>$content_id,'id'=>$paragraph_id]);
        return view('admin.contents.paragraphs.show',compact('paragraph'));
    }

    public function updateContent($content_id,$paragraph_id,Request $request)
    {
        $data = $request->validate([
            'text' => 'required|array',
        ]);
        $paragraph = $this->paragraph->findOneBy(['content_id'=>$content_id,'id'=>$paragraph_id]);


        $paragraph = $this->paragraph->update($paragraph,$data);
        return response()->json([
            'success' => true,
            'paragraph' => $paragraph,
            'message' => __('messages.flash.update')
        ]);
    }


    public function destroy($content_id,$paragraph_id)
    {
        $paragraph = $this->paragraph->findOneBy(['content_id'=>$content_id,'id'=>$paragraph_id]);
        $this->paragraph->destroy($paragraph);
        session()->flash('success',__('messages.flash.delete'));
        return redirect()->route('admin.contents.show',$content_id);
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
