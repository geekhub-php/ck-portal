<?php

namespace Geekhub\AssetsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AssetsBundle extends Bundle
{
    public function getParent()
    {
        return 'AsseticBundle';
    }
}
