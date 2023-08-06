<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParagraphKeyword;
use Illuminate\Http\Request;

class ParagraphKeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($paragraph_id,$keyword_id,Request $request)
    {

        $paragraphKeyword = new ParagraphKeyword();
        $paragraphKeyword->paragraph_id  = $paragraph_id;
        $paragraphKeyword->section_keyword_id  = $keyword_id;
        $paragraphKeyword->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ParagraphKeyword  $paragraphKeyword
     * @return \Illuminate\Http\Response
     */
    public function show(ParagraphKeyword $paragraphKeyword)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ParagraphKeyword  $paragraphKeyword
     * @return \Illuminate\Http\Response
     */
    public function edit(ParagraphKeyword $paragraphKeyword)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ParagraphKeyword  $paragraphKeyword
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ParagraphKeyword $paragraphKeyword)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ParagraphKeyword  $paragraphKeyword
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get id first
        $paragraphKeyword = ParagraphKeyword::where('section_keyword_id',$id)->first();
        //delete
        $paragraphKeywordd =ParagraphKeyword::find( $paragraphKeyword['id']);
        $paragraphKeywordd->delete();

        return redirect()->back();
    }
}
