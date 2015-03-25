<?php
namespace SZ\EZCash;

class Response implements Cryptable
{
    protected $data;

    public function __construct($response)
    {
        $this->data = $response;
    }

    public function getCryptableData()
    {
        return $this->data;
    }
}
