<?php
/**
 * Created by PhpStorm.
 * User: amacabr2
 * Date: 01/05/17
 * Time: 15:13
 */

namespace App\Concern;

use App\Observer\TaggableObserver;
use App\Tag;
use Illuminate\Support\Str;

trait Taggable {

    public static function bootTaggable() {
        static::observe(TaggableObserver::class);
    }

    /**
     * Connection between post ans tags
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Return tags for a post
     */
    public function getTagsListAttribute() {
        return $this->tags->pluck('name')->implode(',');
    }

    /**
     * Save tags for post
     * @param String $tags
     */
    public function saveTags(String $tags) {

        $tags = array_filter(array_unique(array_map(function ($item) {
            return trim(strtolower($item));
        }, explode(',', $tags))), function ($item) {
            return !empty($item);
        });

        $persistedTags = Tag::whereIn('name', $tags)->get();

        $tagsToCreate = array_diff($tags, $persistedTags->pluck('name')->all());
        $tagsToCreate = array_map(function ($tag) {
            return [
                'name' => $tag,
                'slug' => Str::slug($tag),
                'post_count' => 1
            ];
        }, $tagsToCreate);

        $createdTags = $this->tags()->createMany($tagsToCreate);
        $persistedTags = $persistedTags->merge($createdTags);
        $edits = $this->tags()->sync($persistedTags);

        Tag::whereIn('id', $edits['attached'])->increment('post_count', 1);
        Tag::whereIn('id', $edits['detached'])->decrement('post_count', 1);
        Tag::removeUnused();

    }

}