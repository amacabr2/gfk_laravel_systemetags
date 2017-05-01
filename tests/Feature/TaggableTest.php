<?php

namespace Tests\Feature;

use App\Post;
use App\Tag;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TaggableTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate:refresh');
    }

    /**
     * A test tags creation.
     *
     * @return void
     */
    public function testCreateTags()
    {
        $post = Post::create(['name' => 'demo', 'content' => 'lorem']);
        echo $post;
        $post->saveTags('salut,chien,chat');
        $this->assertEquals(3, Tag::count());
    }
}
