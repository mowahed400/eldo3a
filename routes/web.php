<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'admin/dashboard');
Route::view('/otp', 'OTP');


Route::get('/editor/metadata', [\App\Http\Controllers\EditorJsController::class,'getMetaDataFromUrl'])->name('editor.metadata');
Route::post('/editor/upload/file', [\App\Http\Controllers\EditorJsController::class,'uploadFile'])->name('editor.upload.file');
Route::post('/editor/upload/image', [\App\Http\Controllers\EditorJsController::class,'uploadImage'])->name('editor.upload.image');
Route::post('/editor/image/fetchUrl', [\App\Http\Controllers\EditorJsController::class,'imageFetchUrl'])->name('editor.image.fetchUrl');


Route::get('test',function (){
    $p = \App\Models\Paragraph::first();


    $blocks = collect(json_decode($p->text)->blocks ?? [])->whereIn('type',['paragraph','quote','ayat']);
    //dd($blocks);
    $block = $blocks->shuffle()->first();

    $block = strip_tags($block->type === 'ayat' ? $block->data->ayatText : $block->data->text);

    return $block;
});
