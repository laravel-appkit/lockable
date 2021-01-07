<?php

namespace AppKit\Lockable\Tests\Models;

use AppKit\Lockable\Traits\Lockable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Lockable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body'
    ];
}
