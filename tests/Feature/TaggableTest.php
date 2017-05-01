<?php

namespace Tests\Feature;

use App\Post;
use App\Tag;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TaggableTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateTags()
    {
        $post = Post::create(['name' => 'demo', 'content' => 'lorem']);
        $post->saveTags('salut,chien,chat');
        $this->assertEquals(3, Tag::count());
    }
}
