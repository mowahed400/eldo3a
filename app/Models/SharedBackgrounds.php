<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class SharedBackgrounds extends Model
{
    use HasFactory;

    protected $fillable = [
        'image','section_id'
    ];

    protected $appends = [
        'image_url'
    ];

    public function imageUrl() :Attribute
    {
        if ($this->image)
        {
            return new Attribute(
                get: fn() => str($this->image)->contains('http')
                    ? $this->image
                    : Storage::disk(config('filesystems.default'))->url($this->image)
            );
        }

        return new Attribute(get: fn() => asset('assets/admin/app-assets/images/default/default.png'));
    }


    /**
     * @return BelongsTo
     */
    public function Section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
