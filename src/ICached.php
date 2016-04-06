<?php
/**
 * Interface for classes with cached data.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core;


interface ICached
{
    /**
     * Reset caches (this method is useful in tests).
     */
    public function cacheReset();
}