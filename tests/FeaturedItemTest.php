<?php

use App\Models\Token as Token;
use App\Models\Item as Item;

class FeaturedItemTest extends TestCase
{
    /**
     * /items [POST]
     */
    public function test_should_create_new_featured_item()
    {
        // create a user/ token combo
        $token = factory('App\Models\Token')->create();

        $item = Item::all()->last();

        $parameters = [
            'item_id' => $item->id,
        ];

        $response = $this->post("featured", $parameters, ['token' => $token->token])
            ->response
            ->getContent();

        $content = filter_var($response, FILTER_VALIDATE_BOOLEAN);

        $this->seeStatusCode(200);
        $this->assertTrue($content);
    }

    /**
     * /items [GET]
     */
    public function test_should_show_all_featured_items()
    {
        $this->get("featured");

        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' =>
                [
                    'id',
                    'artist',
                    'title',
                    'created_at',
                    'updated_at',
                    'description',
                    'basic_cost',
                    'b2b_cost',
                    'images',
                    'audio',
                    'quantity_available',
                    'catalog',
                    'category',
                    'presale',
                    'b2b_enabled',
                    'direct_enabled',
                ]
            ]);
    }

    /**
     * /items [DELETE]
     */
    public function test_should_delete_existing_featured_item()
    {
        // create a user/ token combo
        $token = factory('App\Models\Token')->create();

        $item = Item::all()->last();

        $response = $this->delete("featured/".$item->id, [], ['token' => $token->token])
            ->response
            ->getContent();

        $content = filter_var($response, FILTER_VALIDATE_BOOLEAN);

        $this->seeStatusCode(200);
        $this->assertTrue($content);
    }
}