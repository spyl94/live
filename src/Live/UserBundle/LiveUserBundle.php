<?php

namespace Live\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LiveUserBundle extends Bundle
{
	 public function getParent()
    {
        return 'FOSUserBundle';
    }
}
