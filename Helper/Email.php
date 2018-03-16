<?php
/**
 * Formatting tool default implementation.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Helper;

/**
 * Default implementation of the email validator.
 */
class Email
    implements \Praxigento\Core\Api\Helper\Email
{
    public function validateRecipient($email, $name = '')
    {
        return [$email, $name];
    }
}