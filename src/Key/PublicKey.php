<?php
/**
 * Entity for key file
 */
namespace SZ\EZCash\Key;

use SplFileObject;

class PublicKey extends SplFileObject
{
    public function __toString()
    {
        $return[] = '-----BEGIN PUBLIC KEY-----';
        $return[] = wordwrap($this->fpassthru(), 64, "\n", true);
        $return[] = '-----END PUBLIC KEY-----';

        return implode("\n", $return);
    }
}