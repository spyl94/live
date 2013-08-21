Site de Live Efrei
========================

1) Installation
----------------------------------

    git clone git@github.com:spyl94/live.git

    php composer.phar install

2) Checking your System Configuration
-------------------------------------

Before starting coding, make sure that your local system is properly
configured for Symfony.

Execute the `check.php` script from the command line:

    php app/check.php

If you get any warnings or recommendations, fix them before moving on.

3) Clearing the cache
-------------------------------------

    php app/console cache:clear

    php app/console cache:clear --env=prod

3) Dump css files
-------------------------------------

    php app/console assetic:dump

    php app/console assetic:dump --env=prod --no-debug

