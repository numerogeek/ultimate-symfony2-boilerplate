<?php

namespace AppBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;

class AppFixtures extends DataFixtureLoader
{
    protected function getFixtures()
    {
        return array(
            __DIR__.'/users.yml',
        );
    }
}
