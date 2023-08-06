<?php

namespace App\Models;

use App\Traits\GlobalObserversTraits;
use App\Traits\Transatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Margin extends Model
{
    use HasFactory,Transatable,GlobalObserversTraits;

    protected $fillable = [
       'name','section_id'
    ];

    protected array $translatable = [
        'name'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
