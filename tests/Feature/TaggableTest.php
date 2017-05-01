<?php

namespace Tests\Feature;

use App\Post;
use App\Tag;
use Faker\Factory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class TaggableTest extends TestCase {

    public function setUp() {
        parent::setUp();
        Artisan::call('migrate:refresh');
    }

    public function listenQuery() {
        Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
           $query->sql;
           echo "\033[0;34m" . $query->sql . "\033[0m <= ";
           echo "\033[0;32m[" . implode(', ', $query->bindings) . "]\033[0m";
           echo "\n";
        });
    }

    /**
     * Test tags creation and connection with post.
     *
     * @return void
     */
    public function testCreateTags() {
        $post = factory(Post::class)->create();
        $post->saveTags('salut,chien,chat,chat');
        $this->assertEquals(3, Tag::count());
        $this->assertEquals(1, Tag::first()->post_count);
        $this->assertEquals(3, DB::table('post_tag')->count());
    }

    /**
     * Test when we do not add tags during the creation of a comment
     */
    public function testEmptyTags() {
        $post = factory(Post::class)->create();
        $post->saveTags('');
        $this->assertEquals(0, Tag::count());
    }

    /**
     * Test if a tag not recreated not so one created an article with an already existing tag
     */
    public function testReuseTags() {
        $posts = factory(Post::class, 2)->create();
        $post1 = $posts->first();
        $post2 = $posts->last();
        $post1->saveTags('salut ,chien, chat, , ');
        $post2->saveTags('salut, chameau');
        $this->assertEquals(4, Tag::count());
        $this->assertEquals(3, DB::table('post_tag')->where('post_id', $post1->id)->count());
        $this->assertEquals(2, DB::table('post_tag')->where('post_id', $post2->id)->count());
        $this->assertEquals(2, Tag::where('name', 'salut')->first()->post_count);
    }

    /**
     * Test count number post for one tag
     */
    public function testPostCountOnTags() {
        $posts = factory(Post::class, 2)->create();
        $post1 = $posts->first();
        $post2 = $posts->last();
        $this->listenQuery();
        $post1->saveTags('salut,chien,chat');
        $post2->saveTags('salut');
        $this->assertEquals(2, Tag::where('name', 'salut')->first()->post_count);
        $post2->saveTags('chien');
        $this->assertEquals(2, Tag::where('name', 'chien')->first()->post_count);
        $this->assertEquals(1, Tag::where('name', 'salut')->first()->post_count);
    }

    /**
     * Test when delete tag unused
     */
    public function testCleanUnusedTags() {
        $post = factory(Post::class)->create();
        $post->saveTags('salut,chien,chat');
        $this->assertEquals(3, Tag::count());
        $post->saveTags('');
        $this->assertEquals(0, Tag::count());
    }

    /**
     * Test when delete post
     */
    public function testDeletePost() {
        $post = factory(Post::class)->create();
        $post->saveTags('salut,chien,chat');
        $this->assertEquals(3, Tag::count());
        $post->delete();
        $this->assertEquals(0, Tag::count());
    }

}
