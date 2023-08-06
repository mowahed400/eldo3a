<?php

namespace App\Http\Controllers;

use App\Traits\UploadAble;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use mobiosolutions\metatags\Metatags;

class EditorJsController extends Controller
{
    use UploadAble;

    public function getMetaDataFromUrl(Request $request): \Illuminate\Http\JsonResponse
    {
        $mt= new Metatags();

        if (validator($request->all(),['url'=> 'required|string|url'])->fails())
        {
            return response()->json([
                'success' => 1,
                'meta' => [],
                'message' => 'url required',
            ]);
        }

        try {
            $metadata = $mt->get($request->input('url'),true);

            $meta = [];

            if (array_key_exists('og:image',$metadata))
            {
                $meta['image'] = [
                    'url' => $metadata['og:image'],
                ];
            }

            if (array_key_exists('og:title',$metadata))
            {
                $meta['title'] = $metadata['og:title'];
            }

            if (array_key_exists('og:title',$metadata))
            {
                $meta['title'] = $metadata['og:title'];
            }

            if (array_key_exists('og:url',$metadata))
            {
                $meta['url'] = $metadata['og:url'];
            }

            if (array_key_exists('og:site_name',$metadata))
            {
                $meta['site_name'] = $metadata['og:site_name'];
            }

            if (array_key_exists('og:description',$metadata))
            {
                $meta['description'] = $metadata['og:description'];
            }

            return response()->json([
                'success' => 1,
                'meta' => $meta,
            ]);
        }catch (\Exception | Error $exception)
        {
            return response()->json([
                'success' => 1,
                'meta' => [],
                'message' => 'oops something went wrong',
                'exception_message' => $exception->getMessage()
            ]);
        }
    }

    public function uploadFile(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'file' => 'required|file|max:20000'
        ]);
        $file = $request->file('file');
        $path = $this->uploadOne($file,'editor/files');

        return response()->json([
            'success' => 1,
            'file' => [
                'url' => Storage::disk(config('filesystems.default'))->url($path),
                'name' => $file->getClientOriginalName(),
                'title' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'extension' => $file->getClientOriginalExtension(),
            ]
        ]);

    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|file|image|max:10000'
        ]);
        $file = $request->file('image');
        $path  = $this->uploadOne($file,'editor/images');
        return response()->json([
            'success' => 1,
            'file' =>[
                'url' => asset('storage/'.$path),
                'name' => $file->getClientOriginalName(),
                'title' => $file->getClientOriginalName(),
            ]
        ]);
    }

    public function imageFetchUrl(Request $request)
    {
        $data = $request->validate(['url' => 'required|string|url']);

        $contents = file_get_contents($data['url']);
        // $file_name = basename($url_upper);
        $file_name = strtolower(substr($data['url'], strrpos($data['url'], '/') + 1));
        $path = 'editor/images/'.$file_name;
        Storage::disk(config('filesystems.default'))->put($path, $contents);

        return response()->json([
            'success' => 1,
            'file' => [
                'url' => Storage::disk(config('filesystems.default'))->url($path),
                'name' => $file_name,
                'title' => $file_name,
                // ... and any additional fields you want to store, such as width, height, color, extension, etc
            ]
        ]);
    }



}
