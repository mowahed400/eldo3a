<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionKeywordRequest;
use App\Models\Section;
use App\Models\SectionKeyword;
use Illuminate\Http\Request;

class SectionKeywordController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $keywords = SectionKeyword::orderBy('section_id','ASC')->get();

        $sections = Section::all('id','name');

        for($i = 0;$i<count($keywords);$i++){
            for($j = 0 ; $j<count($sections);$j++){
                if($keywords[$i]->section_id == $sections[$j]->id){
                    $keywords[$i]->section_name =  $sections[$j]->name;
                }
            }
        }

       return view('admin.sections.keywords.index')->with('keywords',$keywords);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.sections.keywords.create')->with('sections',Section::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(SectionKeywordRequest $sectionKeywordRequest)
    {
        $data = $sectionKeywordRequest->validated();

        SectionKeyword::create([
            "section_id"=>$data['section_id'],
            "keyword"=>$data['keyword']
        ]);

        return redirect()->route('admin.section_keywords.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SectionKeyword  $sectionKeyword
     * @return \Illuminate\Http\Response
     */
    public function show(SectionKeyword $sectionKeyword)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SectionKeyword  $sectionKeyword
     * @return \Illuminate\Http\Response
     */
    public function edit(SectionKeyword $sectionKeyword)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SectionKeyword  $sectionKeyword
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SectionKeyword $sectionKeyword)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SectionKeyword  $sectionKeyword
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sectionKeyword = SectionKeyword::find($id);
        $sectionKeyword->delete();

        return redirect()->route('admin.section_keywords.index');
    }

}
