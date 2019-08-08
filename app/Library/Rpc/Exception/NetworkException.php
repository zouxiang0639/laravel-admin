<?php
namespace App\Library\Rpc\Exception;


class NetworkException extends \Exception
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