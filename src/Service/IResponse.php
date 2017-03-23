<?php
/**
 * Interface for services responses implementations.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Core\Service;


interface IResponse
{
    /**#@+
     * Base error codes.
     */
    const ERR_NO_ERROR = 'no_error';
    const ERR_UNDEFINED = 'undefined';
    const ERR_VALIDATION = 'validation_err';
    /**#@- */

    /**
     * @return string
     */
    public function getErrorCode();

    /**
     * @return string
     */
    public function getErrorMessage();

    /**
     * Return 'true' if this response is corresponded to successfully completed operation.
     * @return boolean
     */
    public function isSucceed();

    /**
     * Mark response as succeed.
     */
    public function markSucceed();

    /**
     * @param string $data
     */
    public function setErrorCode($data);

    /**
     * @param string $data
     */
    public function setErrorMessage($data);
}