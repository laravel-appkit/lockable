<?php

namespace AppKit\:package_name_php\Tests;

use AppKit\:package_name_php\Tests\Models\Article;
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
