<?php

namespace App\Observer;

use App\Post;
use App\Tag;

class TaggableObserver {

    /**
     * Delete tags unused
     *
     * @param Post $post
     */
    public function deleting(Post $post) {
        $tags_id = $post->tags->pluck('id');
        Tag::whereIn('id', $tags_id)->decrement('post_count', 1);
        Tag::removeUnused();
    }

}