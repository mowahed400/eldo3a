<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParagraphKeyword extends Model
{
    use HasFactory;

    protected $fillable = [
        'paragraph_id',
        'section_keyword_id'
    ];

    /**
     * @return HasMany
     */
    public function paragraphsKeywords(): HasMany
    {
        return $this->hasMany(SectionKeyword::class);
    }

}
