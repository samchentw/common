<?php

namespace Samchentw\Common\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Samchentw\Common\CommonServiceProvider;

class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            CommonServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
    }
}
