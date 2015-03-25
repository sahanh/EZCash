<?php
/**
 * Entity for key file
 */
namespace SZ\EZCash\Key;

class PrivateKey extends Key
{
    public function getFormattedKey()
    {
        $return   = array();
        $return[] = '-----BEGIN PRIVATE KEY-----';
        $return[] = wordwrap($this->getContent(), 64, "\n", true);
        $return[] = '-----END PRIVATE KEY-----';

        return implode("\n", $return);
    }
}
