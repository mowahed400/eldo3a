<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SharedBackgoundRequest;
use App\Http\Resources\BackgroundsResource;
use App\Models\Section;
use App\Models\SharedBackgrounds;
use Illuminate\Http\Request;

class SharedBackgroundsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:create-shared-backgrounds'])->only(['create','store']);
        $this->middleware(['permission:view-shared-backgrounds'])->only(['index']);
        $this->middleware(['permission:delete-shared-backgrounds'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $backgrounds = SharedBackgrounds::orderBy('section_id','ASC')->get();

        $sections = Section::all('id','name');
        for($i = 0;$i<count($backgrounds);$i++){
            for($j = 0 ; $j<count($sections);$j++){
                if($backgrounds[$i]->section_id == $sections[$j]->id){
                    $backgrounds[$i]->section_name =  $sections[$j]->name;
                }
            }
        }

        return view('admin.shared_backgrounds.index')->with('backgrounds',$backgrounds) ;  //json_encode( $backgrounds);//
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shared_backgrounds.create')->with('sections',Section::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SharedBackgoundRequest $sharedBackgroundRequest)
    {
        $data = $sharedBackgroundRequest->validated();
        $featured = $data['image'];
        $featuredName  = time().$featured->getClientOriginalName() ;
        $featured->move(storage_path('app/public/shared_backgrounds'),$featuredName);

      SharedBackgrounds::create(
            [
                "section_id"=>$data['section_id'],
                "image"=>'shared_backgrounds/'.$featuredName
            ]
        );

        return redirect()->route('admin.shared_backgrounds.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SharedBackgrounds  $sharedBackgrounds
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $backgrounds = SharedBackgrounds::where('section_id',$id)->get();

        return  BackgroundsResource::collection(
            $backgrounds
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SharedBackgrounds  $sharedBackgrounds
     * @return \Illuminate\Http\Response
     */
    public function edit(SharedBackgrounds $sharedBackgrounds)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SharedBackgrounds  $sharedBackgrounds
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SharedBackgrounds $sharedBackgrounds)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SharedBackgrounds  $sharedBackgrounds
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $background = SharedBackgrounds::find($id);
        $background->delete();

        return  redirect()->route('admin.shared_backgrounds.index');
    }
}
