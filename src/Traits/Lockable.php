<?php

namespace AppKit\Lockable\Traits;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait Lockable
{
    private $acquiringLock = false;

    public static function bootLockable()
    {
        static::updating(function (Model $model) {
            // are we currently acquiring the lock
            if ($model->acquiringLock) {
                // if we are, we always want to allow the update
                $model->acquiringLock = false;

                return true;
            }

            if ($model->locked_by && $model->locked_by == Auth::id()) {
                return true;
            }

            // throw an exception
            throw new Exception('User does not hold the lock to this model.');

            // stop the update
            return false;
        });
    }

    /**
     * Acquire the lock for this model
     *
     * @return boolean
     */
    public function acquireLock(): bool
    {
        // set the flag to make sure that locks can be acquired
        $this->acquiringLock = true;

        // set the column required to save the lock
        $this->locked_by = Auth::id();

        // save the update
        return $this->save();
    }

    /**
     * Release the lock for this model
     *
     * @return boolean
     */
    public function releaseLock(): bool
    {
        // set the flag to make sure that locks can be released
        $this->acquiringLock = true;

        // set the column required to clear the lock
        $this->locked_by = null;

        // save the update
        return $this->save();
    }
}
