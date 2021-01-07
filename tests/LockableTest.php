<?php

namespace AppKit\Lockable\Tests;

use Illuminate\Support\Facades\Schema;

class LockableTest extends TestCase
{
    /** @test */
    public function migrationsCanContainLockableColumns()
    {
        // when lockable is created on a migration

        // the table contains a locked_by and locked_until column
        $this->assertTrue(Schema::hasColumn('articles', 'locked_by'));
        $this->assertTrue(Schema::hasColumn('articles', 'locked_until'));
    }
}
