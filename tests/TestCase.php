<?php

namespace Alacrity\Responses\Tests;

use Alacrity\Responses\Facades\Respond;
use Alacrity\Responses\Http\Responses\CreatedResponse;
use Alacrity\Responses\Http\Responses\DeletedResponse;
use Alacrity\Responses\Http\Responses\IndexResponse;
use Alacrity\Responses\Http\Responses\ShowResponse;
use Alacrity\Responses\Http\Responses\UpdatedResponse;
use Alacrity\Responses\Tests\Models\User;
use Alacrity\Responses\Tests\Transformers\UserTransformer;
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

        Route::delete('/api/user/{id}', function () {
            return new DeletedResponse();
        });

        // Without model responses.
        Route::post('/api/user', function (\Illuminate\Http\Request $request) {
            return new CreatedResponse();
        });

        Route::patch('/api/user/{id}', function (\Illuminate\Http\Request $request, $id) {
            return new UpdatedResponse();
        });

        // With model responses.
        Route::post('/api/user-with-model', function (\Illuminate\Http\Request $request) {
            $user = User::create($request->only(['name', 'email', 'password']));

            // Example using the helper method
            return respond()->with($user, new UserTransformer())->created();
        });

        Route::patch('/api/user-with-model/{id}', function (\Illuminate\Http\Request $request, $id) {
            $user = User::find($id);
            $user->update($request->only(['name']));

            // Example using the facade.
            return Respond::with($user, new UserTransformer())->updated();
        });
    }
}
