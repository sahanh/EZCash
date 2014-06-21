<?php
/**
 * Entity for key file
 */
namespace SZ\EZCash\Key;

use SplFileObject;

class Private extends SplFileObject
{
    public function __toString()
    {
        $return[] = '-----BEGIN PRIVATE KEY-----';
        $return[] = wordwrap($this->fpassthru(), 64, "\n", true);
        $return[] = '-----END PRIVATE KEY-----';

        return implode("\n", $return);
    }
}