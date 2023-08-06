<?php

namespace App\Models;

use App\Enums\CategoryState;
use App\Enums\CategoryType;
use App\Enums\SectionState;
use App\Traits\GlobalObserversTraits;
use App\Traits\Transatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory,Transatable,GlobalObserversTraits;

    protected $fillable = [
        'name',
        'description',
        'state',
        'image',
        'color',
        'sort_index',
        'section_id',
        'type',
        'parent_id'
    ];

    protected array $translatable = [
        'name','description'
    ];

    protected $casts = [
        'state' => CategoryState::class,
        'type' => CategoryType::class,
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

    public function isChild(): bool
    {
        if ($this->parent()->exists())
        {
            return  true;
        }
        return false;
    }

    public function scopeParentCategories($query): Builder
    {
        return $query->where('parent_id',null);
    }

    public function scopeChildCategories($query): Builder
    {
        return $query->where('parent_id','<>',null);
    }


    /**
     * @return BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class,'parent_id','id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class,'parent_id','id');
    }

    public function scopeActive($query)
    {
        $query->where('state',SectionState::ACTIVE);
    }

    public function scopeInActive($query)
    {
        $query->where('state',SectionState::INACTIVE);
    }
}
