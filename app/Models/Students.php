<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'school_id', 'order'];

    public function schools()
    {
        return $this->belongsTo(Schools::class,"school_id");
    }
}
