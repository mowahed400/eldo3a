<?php

namespace App\Models;

use App\Traits\GlobalObserversTraits;
use App\Traits\Transatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paragraph extends Model
{
    use HasFactory,Transatable,GlobalObserversTraits;

    protected $fillable = [
        'text',
        'start_from',
        'end_at',
        'content_id',

    ];

    protected array $translatable = [
        'start_from','end_at','text'
    ];

    public function content(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Content::class);
    }

}
