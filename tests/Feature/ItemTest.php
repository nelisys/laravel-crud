<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Item;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_list_items()
    {
        $items = factory(Item::class, 4)->create();

        $this->json('GET', "/api/items")
            ->assertStatus(200)
            ->assertJson([
                'data' => $items->toArray(),
                'links' => [
                    'first' => env('APP_URL') . "/api/items?page=1",
                    'last' => env('APP_URL') . "/api/items?page=1",
                    'prev' => null,
                    'next' => null
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => env('APP_URL') . '/api/items',
                    'per_page' => 15,
                    'to' => $items->count(),
                    'total' => $items->count(),
                ],
            ]);
    }

    /** @test */
    public function a_user_can_view_an_item()
    {
        $item = factory(Item::class)->create();

        $this->json('GET', "/api/items/{$item->id}")
            ->assertStatus(200)
            ->assertJson([
                'data' => $item->toArray(),
            ]);
    }

    /** @test */
    public function a_user_can_create_an_item()
    {
        $item = factory(Item::class)->make();

        $this->json('POST', "/api/items", $item->toArray())
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                ],
            ])
            ->assertJson([
                'data' => $item->toArray(),
            ]);

        $this->assertDatabaseHas("items", $item->toArray());
    }

    /** @test */
    public function a_user_can_update_an_item()
    {
        $item = factory(Item::class)->create();

        $update_data = factory(Item::class)->make();

        $this->json('PATCH', "/api/items/{$item->id}", $update_data->toArray())
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                ],
            ])
            ->assertJson([
                'data' => $update_data->toArray(),
            ]);

        $this->assertDatabaseHas("items", $update_data->toArray());
    }

    /** @test */
    public function a_user_can_delete_an_item()
    {
        $item = factory(Item::class)->create();

        $this->json('DELETE', "/api/items/{$item->id}")
            ->assertStatus(200);

        $this->assertDatabaseMissing("items", [
            'id' => $item->id,
        ]);
    }
}