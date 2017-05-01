<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    public $guarded = [];
    public $timestamps = false;

    /**
     * Connection between tag and posts
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts() {
        return $this->belongsToMany(Post::class);
    }

    public static function removeUnused() {
        return static::where('post_count', 0)->delete();
    }

}
