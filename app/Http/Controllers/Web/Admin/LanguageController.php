<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LanguageController extends Controller
{

    public function __construct()
    {
        #$this->middleware(['permission:view-list-language'])->only(['index']);
        #$this->middleware(['permission:create-language'])->only(['index']);
        #$this->middleware(['permission:delete-language'])->only(['destroy']);
    }

    public function index() : Renderable
    {
        return view('admin.languages.index');
    }

    public function store(Request $request) : RedirectResponse
    {
        $data = $request->validate([

            'name' => 'required|string|max:40',

            'dir' => 'required|string|in:ltr,rtl',
        ]);

        $langs = getLangs();
        if (array_key_exists($data['name'],$langs))
        {
            throw ValidationException::withMessages([
                'name' => __('validation.unique',['attribute' => __('labels.fields.name')])
            ]);
        }

        $langs[$data['name']] = [
            'dir' => $data['dir'],
            'active' => true
        ];

        Setting::set('lang',json_encode($langs));

        session()->flash('success',__('messages.flash.create'));
        return redirect()->route('admin.languages.index');

    }


    public function edit($lang) //: Renderable
    {
        $data=[];
        $specificLang = getLangs();
        if (array_key_exists($lang,$specificLang))
        {
            $data =  ['name'=>$lang,'dir'=>$specificLang[$lang]['dir']];//$specificLang[$lang];
        }
        $lang=$data;
        return view('admin.languages.edit',compact('lang'));
    }

    public function update(Request $request,$lang)//: RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:40',
            'dir' => 'required|string|in:ltr,rtl',
        ]);

        $langs = getLangs();

        if(!array_key_exists($data['name'],$langs)){
            $langs[$lang] = [
                'dir' => $data['dir'],
                'active' => true
            ];

            $langs[$data['name']] = $langs[$lang];
            unset($langs[$lang]);

            Setting::set('lang',json_encode($langs));


            session()->flash('success',__('messages.flash.edit'));
            return redirect()->route('admin.languages.index');
        }

        session()->flash('success',__('messages.flash.edit'));
        return redirect()->route('admin.languages.index');

    }



    public function destroy($id)
    {
        if (!array_key_exists($id,getLangs()))
        {
            abort(404);
        }

        if ($id === 'ar')
        {
            abort(403);
        }

        $langs = getLangs();

        unset($langs[$id]);

        Setting::set('lang',json_encode($langs));

        session()->flash('success',__('messages.flash.delete'));
        return redirect()->route('admin.languages.index');
    }
}
