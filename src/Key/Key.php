<?php
namespace SZ\EZCash\Key;

use SplFileObject;

abstract class Key extends SplFileObject
{
    public function getContent()
    {
        $content = '';
        while (!$this->eof()) {
            $content .= $this->fgets();
        }

        return $content;
    }

    public function __toString()
    {
        return $this->getFormattedKey();
    }
}