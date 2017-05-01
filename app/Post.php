<?php

namespace App;

use App\Concern\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{

    use Taggable;

    public $fillable = ['name', 'content'];

}
