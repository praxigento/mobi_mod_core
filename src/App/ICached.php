<?php
/**
 * Interface for classes with cached data.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\App;

/**
 * @deprecated was used in a tests but we have no tests at now.
 */
interface ICached
{
    /**
     * Reset caches (this method is useful in tests).
     */
    public function cacheReset();
}