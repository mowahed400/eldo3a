<?php

namespace App\Http\Controllers\Web\Admin;

use App\Contracts\MarginContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\MarginRequest;
use Illuminate\Http\Request;

class MarginController extends Controller
{
    protected MarginContract $margin;

    public function __construct(MarginContract $margin)
    {
        $this->margin = $margin;
    }

    public function store($id,MarginRequest $request)
    {
        $data = $request->validated();
        $data['section_id'] = $id;
        $this->margin->new($data);
        session()->flash('success',__('messages.flash.create'));
        return to_route('admin.sections.show',$id);
    }

    public function edit($id)
    {
        $margin = $this->margin->findOneById($id);
        return view('admin.sections.margins.edit',compact('margin'));
    }

    public function update($id,MarginRequest $request)
    {
        $data = $request->validated();
        $margin = $this->margin->update($id,$data);
        session()->flash('success',__('messages.flash.update'));
        return to_route('admin.sections.show',$margin->section_id);
    }

    public function destroy($id)
    {
        $margin = $this->margin->destroy($id);
        session()->flash('success',__('messages.flash.delete'));
        return redirect()->back();
    }

}
