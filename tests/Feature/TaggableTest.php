<?php

namespace Tests\Feature;

use App\Post;
use App\Tag;
use Faker\Factory;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TaggableTest extends TestCase {

    public function setUp() {
        parent::setUp();
        Artisan::call('migrate:refresh');
    }

    /**
     * Test tags creation.
     *
     * @return void
     */
    public function testCreateTags() {
        $post = factory(Post::class)->create();
        $post->saveTags('salut,chien,chat');
        $this->assertEquals(3, Tag::count());
    }

    /**
     * Test if a tag not recreated not so one created an article with an already existing tag
     */
    public function testReuseTags() {
        $posts = factory(Post::class, 2)->create();
        $post1 = $posts->first();
        $post2 = $posts->last();
        $post1->saveTags('salut,chien,chat');
        $post2->saveTags('salut,chameau');
        $this->assertEquals(4, Tag::count());
    }

}
