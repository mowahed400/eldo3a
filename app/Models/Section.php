<?php

namespace App\Models;

use App\Enums\SectionState;
use App\Enums\SectionType;
use App\Traits\GlobalObserversTraits;
use App\Traits\Transatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Section extends Model
{
    use HasFactory,Transatable,GlobalObserversTraits;

    protected $fillable = [
        'name','image',
        //'color',
        'sort_index','description','state','settings',
        'type'
    ];

    protected $casts = [
        'state' => SectionState::class,
        'type' => SectionType::class,
        'settings' => 'array',
    ];

    protected $appends = [
        'image_url'
    ];

    protected array $translatable = [
        'name','description'
    ];

    public function imageUrl(): Attribute
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
     * @return HasMany
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * @return HasMany
     */
    public function photos(): HasMany
    {
        return $this->hasMany(SharedBackgrounds::class);
    }

    /**
     * @return HasMany
     */
    public function sectionKeywords(): HasMany
    {
        return $this->hasMany(SectionKeyword::class);
    }




    public function getSettings(string $key)
    {
        return $this->settings[$key] ?? null;
    }

    public function scopeActive($query)
    {
        $query->where('state',SectionState::ACTIVE);
    }

    public function scopeInActive($query)
    {
        $query->where('state',SectionState::INACTIVE);
    }

    public function margins()
    {
        return $this->hasMany(Margin::class);
    }
}
