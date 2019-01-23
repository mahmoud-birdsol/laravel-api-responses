<?php

namespace Alacrity\Responses\Tests\Unit;

use Alacrity\Responses\Respond;
use Alacrity\Responses\Tests\TestCase;
use Alacrity\Responses\Tests\Models\User;
use Alacrity\Responses\Http\Responses\ShowResponse;
use Alacrity\Responses\Http\Responses\IndexResponse;
use Alacrity\Responses\Http\Responses\CreatedResponse;
use Alacrity\Responses\Http\Responses\DeletedResponse;
use Alacrity\Responses\Http\Responses\UpdatedResponse;
use Alacrity\Responses\Tests\Transformers\UserTransformer;

class RespondTest extends TestCase
{
    /** @test */
    public function it_returns_an_index_response()
    {
        $respond = new Respond();

        $builder = User::query();
        $transformer = new UserTransformer();

        $this->assertInstanceOf(IndexResponse::class, $respond->index($builder, $transformer));
    }

    /** @test */
    public function it_returns_a_show_response()
    {
        $respond = new Respond();

        $model = factory(User::class)->create();
        $transformer = new UserTransformer();

        $this->assertInstanceOf(ShowResponse::class, $respond->with($model, $transformer)->show());
    }

    /** @test */
    public function it_returns_a_show_response_with_model_from_method()
    {
        $respond = new Respond();

        $model = factory(User::class)->create();
        $transformer = new UserTransformer();

        $this->assertInstanceOf(ShowResponse::class, $respond->show($model, $transformer));
    }

    /** @test */
    public function it_returns_a_created_response_with_model()
    {
        $respond = new Respond();

        $model = factory(User::class)->create();
        $transformer = new UserTransformer();

        $this->assertInstanceOf(CreatedResponse::class, $respond->with($model, $transformer)->created());
    }

    /** @test */
    public function it_returns_an_updated_response_with_model()
    {
        $respond = new Respond();

        $model = factory(User::class)->create();
        $transformer = new UserTransformer();

        $this->assertInstanceOf(UpdatedResponse::class, $respond->with($model, $transformer)->updated());
    }

    /** @test */
    public function it_returns_a_created_response_without_model()
    {
        $respond = new Respond();

        $this->assertInstanceOf(CreatedResponse::class, $respond->created());
    }

    /** @test */
    public function it_returns_an_updated_response_without_model()
    {
        $respond = new Respond();

        $this->assertInstanceOf(UpdatedResponse::class, $respond->updated());
    }

    /** @test */
    public function it_returns_a_deleted_response()
    {
        $respond = new Respond();

        $this->assertInstanceOf(DeletedResponse::class, $respond->deleted());
    }
}
