<?php

namespace Alacrity\Responses\Tests;

use Alacrity\Responses\Http\Responses\IndexResponse;
use Alacrity\Responses\Http\Responses\ShowResponse;
use Alacrity\Responses\Tests\Feature\ShowResponseTest;
use Alacrity\Responses\Tests\Models\User;
use Alacrity\Responses\Tests\Transformers\UserTransformer;
use Homicity\Reviews\Test\Traits\Authentication;
use Homicity\Reviews\Test\Traits\ReviewsRepository;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Setup the test case.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testbench']);
        $this->withFactories(__DIR__ . '/database/factories');

        $this->registerTestingRoutes();
    }

    /**
     * Tear down the test case.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Get the service providers for the package.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            'Alacrity\Responses\Providers\ResponseServiceProvider',
        ];
    }

    /**
     * Configure the environment.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        foreach ($this->extraConfigs() as $key => $value) {
            $app['config']->set($key, $value);
        }
    }

    /**
     * Override this method to set configuration values in your test class
     *
     * @return array of config keys (in dot-notation) and values
     */
    protected function extraConfigs(): array
    {
        return [
            'app.debug' => true,
        ];
    }

    /**
     * Run the migrations registered in the app
     */
    protected function loadRegisteredMigrations()
    {
        $this->artisan('migrate');

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });
    }

    /**
     * Register routes to test the requests.
     *
     * @return void
     */
    public function registerTestingRoutes()
    {
        Route::get('/api/user', function () {
            return new IndexResponse(User::query(), new UserTransformer());
        });

        Route::get('/api/user/{id}', function ($id) {
            return new ShowResponse(User::find($id), new UserTransformer());
        });
    }
}
