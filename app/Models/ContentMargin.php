<?php

namespace App\Models;

use App\Traits\GlobalObserversTraits;
use App\Traits\Transatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentMargin extends Model
{
    use HasFactory,Transatable,GlobalObserversTraits;

    protected $fillable = [
        'content_id',
        'margin_id',
        'name',
        'description',
    ];

    protected array $translatable = [
        'name','description'
    ];

    public function margin()
    {
        return $this->belongsTo(Margin::class);
    }

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
