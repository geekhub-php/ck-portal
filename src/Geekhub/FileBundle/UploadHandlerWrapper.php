<?php

namespace Geekhub\FileBundle;

class UploadHandlerWrapper
{
    public function __construct($options = array())
    {
        return new \UploadHandler($options);
    }
}