<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    public $guarded = [];
    public $timestamps = false;

    public function posts() {
        return $this->belongsToMany(Tag::class);
    }

}
