<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SectionKeyword extends Model
{
    use HasFactory;

    protected $fillable = [
       'section_id','keyword'
    ];

    public function Section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
