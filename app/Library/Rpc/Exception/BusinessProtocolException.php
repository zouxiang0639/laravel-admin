<?php
namespace App\Library\Rpc\Exception;

use Exception;

/**
 * Class BusinessProtocolException
 */
class BusinessProtocolException extends Exception
{
    protected $raw;

    /**
     * @param $raw
     * @return $this
     */
    public function setRawResponse($raw)
    {
        $this->raw = $raw;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRawResponse()
    {
        return $this->raw;
    }
}