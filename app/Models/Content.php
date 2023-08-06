<?php

namespace App\Models;

use App\Traits\GlobalObserversTraits;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Content extends Model
{
    use HasFactory,GlobalObserversTraits;

    protected $fillable = [
        'category_id','voice_en','voice_ar','voice','section_id'
    ];

    protected $appends = [
        'voice_en_url','voice_ar_url','voice_url'
    ];

    protected $casts = [
        'voice' => 'array'
    ];

    public function voiceUrl():Attribute
    {
        $urls = [];

        foreach (getLangs() as $lang => $config)
        {
            $urls[$lang] =  $this->voice && isset($this->voice[$lang])
                ? Storage::disk(config('filesystems.default'))->url($this->voice[$lang])
                : null;
        }

        return new Attribute(
            get: fn () => $urls
        );
    }

    public function voiceEnUrl():Attribute
    {
        return new Attribute(
            get: fn () => $this->voice_en
                ? Storage::disk(config('filesystems.default'))->url($this->voice_en)
                : null
        );
    }

    public function voiceArUrl():Attribute
    {
        return new Attribute(
            get: fn () => $this->voice_ar
                ? Storage::disk(config('filesystems.default'))->url($this->voice_ar)
                : null
        );
    }
    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function paragraphs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Paragraph::class);
    }

    public function margins()
    {
        return $this->hasMany(ContentMargin::class);
    }
}
