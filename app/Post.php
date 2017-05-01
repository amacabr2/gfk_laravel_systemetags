<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{

    public $fillable = ['name', 'content'];

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function saveTags(String $tags) {
        $tags = explode(',', $tags);
        $tagsToCreate = array_map(function ($tag) {
            return ['name' => $tag, 'slug' => Str::slug($tag)];
        }, $tags);
        Tag::insert($tagsToCreate);
    }

}
