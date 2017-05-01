<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{

    public $fillable = ['name', 'content'];

    /**
     * Connection between post ans tags
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Save tags for post
     * @param String $tags
     * @return bool
     */
    public function saveTags(String $tags) {

        $tags = array_filter(array_unique(array_map(function ($item) {
            return trim($item);
        }, explode(',', $tags))), function ($item) {
            return !empty($item);
        });

        $persistedTags = Tag::whereIn('name', $tags)->get();

        $tagsToCreate = array_diff($tags, $persistedTags->pluck('name')->all());
        $tagsToCreate = array_map(function ($tag) {
            return ['name' => $tag, 'slug' => Str::slug($tag), 'post_count' => 1];
        }, $tagsToCreate);

        $createdTags = $this->tags()->createMany($tagsToCreate);
        $persistedTags = $persistedTags->merge($createdTags);
        $edits = $this->tags()->sync($persistedTags);

        Tag::whereIn('id', $edits['attached'])->increment('post_count', 1);
        Tag::whereIn('id', $edits['detached'])->decrement('post_count', 1);
        Tag::where('post_count', 0)->delete();

    }

}
