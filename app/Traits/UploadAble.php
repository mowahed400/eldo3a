<?php


namespace App\Traits;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadAble
{
    /**
     * @param UploadedFile $file
     * @param null $folder
     * @param string|null $disk
     * @param null $filename
     * @return false|string
     */
    public function uploadOne(UploadedFile $file, $folder = null, string $disk = null, $filename = null)
    {
        $name = $filename ?? Str::random(25). '.' . $file->getClientOriginalExtension();
        $disk = $disk ?? (string) config('filesystems.default');
        return $file->storeAs(
            $folder,
            $name ,
            $disk
        );
    }

    /**
     * @param null $path
     * @param null|string $disk
     */
    public function deleteOne($path = null, string $disk = null): void
    {

        $disk = $disk ?? (string) config('filesystems.default');
        Storage::disk($disk)->delete($path);
    }

    public function getFullPath($path , $disk = null): string
    {
        $disk = $disk ?? (string) config('filesystems.default');
        return Storage::disk($disk)->path($path);
    }


}
