<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;



    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        $this->app['config']->set('scout.driver', null);
    }
    protected function tearDown(): void
    {
        // Optionally, reset Scout driver to its original value after each test
        $this->app['config']->set('scout.driver', env('SCOUT_DRIVER', 'meilisearch'));

        parent::tearDown();
    }
}
