<?php
/**
 * Entity for key file
 */
namespace SZ\EZCash\Key;

class PublicKey extends Key
{
    public function getFormattedKey()
    {
        $return   = array();
        $return[] = '-----BEGIN PUBLIC KEY-----';
        $return[] = wordwrap($this->getContent(), 64, "\n", true);
        $return[] = '-----END PUBLIC KEY-----';

        return implode("\n", $return);
    }
}