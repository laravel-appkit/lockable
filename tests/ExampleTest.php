<?php

namespace AppKit\Lockable\Tests;

use AppKit\Lockable\Tests\Models\Article;

class ExampleTest extends TestCase
{
    /** @test */
    public function trueIsTrue()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function artcilesCanBeLoaded()
    {
        // create 5 articles
        factory(Article::class, 5)->create();

        // check the database for 5 articles
        $this->assertEquals(5, Article::count());
    }
}
