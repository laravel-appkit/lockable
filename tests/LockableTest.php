<?php

namespace AppKit\Lockable\Tests;

use AppKit\Lockable\Tests\Models\Article;
use AppKit\Lockable\Tests\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class LockableTest extends TestCase
{
    /** @test */
    public function migrationsCanContainLockableColumns()
    {
        // when lockable is created on a migration

        // the table contains a locked_by column
        $this->assertTrue(Schema::hasColumn('articles', 'locked_by'));
    }

    /** @test */
    public function modelsCanNotBeUpdatedIfTheUserDoesntOwnTheLock()
    {
        // theres going to be an exception
        $this->expectException(Exception::class);

        // given a user
        $user = factory(User::class)->create();
        Auth::login($user);

        // and an article
        $article = factory(Article::class)->create();
        /** @var Article $article */

        // when it is updated
        $article->update(['title' => 'This is an updated title']);
        $article->save();

        // the database does not update
        $article = $article->fresh();

        $this->assertNotEquals('This is an updated title', $article->title);
    }

    /** @test */
    public function locksCanBeAcquiredOnAModel()
    {
        // given a user
        $user = factory(User::class)->create();
        Auth::login($user);

        // and an article
        $article = factory(Article::class)->create();
        /** @var Article $article */

        // a lock can be acquired
        $article->acquireLock();

        // the database has the correct lock details
        $article = $article->fresh();

        $this->assertEquals($user->id, $article->locked_by);
    }

    /** @test */
    public function locksCanBeReleasedOnAModel()
    {
        // given a user
        $user = factory(User::class)->create();
        Auth::login($user);

        // and an article
        $article = factory(Article::class)->create();
        /** @var Article $article */

        // a lock can be acquired
        $article->acquireLock();

        // a lock can then be released
        $article = $article->fresh();
        $article->releaseLock();

        // the database has the correct lock details
        $article = $article->fresh();

        $this->assertNull($article->locked_by);
    }

    /** @test */
    public function ifTheUserHoldsTheLockTheyCanUpdate()
    {
        // given a user
        $user = factory(User::class)->create();
        Auth::login($user);

        // and an article
        $article = factory(Article::class)->create();
        /** @var Article $article */

        // the user locks the article
        $article->acquireLock();

        // a lock can then be released
        $article = $article->fresh();

        // when it is updated
        $article->update(['title' => 'This is an updated title']);
        $article->save();

        // the database does not update
        $article = $article->fresh();

        $this->assertEquals('This is an updated title', $article->title);
    }
}
