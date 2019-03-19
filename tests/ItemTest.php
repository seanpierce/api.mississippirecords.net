<?php

use App\Models\Token as Token;

class ItemTest extends TestCase
{
    /**
     * /items [GET]
     */
    public function test_should_show_all_items()
    {
        $this->get("items", []);
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
     * /items/[id] [GET]
     */
    public function test_should_show_single_item()
    {
        $this->get("items/1");
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
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
            ]);
    }

    /**
     * /items [POST]
     */
    public function test_should_create_new_item()
    {
        // create a user/ token combo
        $token = factory('App\Models\Token')->create();

        $parameters = [
            'artist' => 'Test Artist',
            'title' => 'Test Title',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'basic_cost' => 2000,
            'b2b_cost' => 1500,
            'images' => ['my_image.jpg'],
            'audio' => 'my_audio.mp3',
            'quantity_available' => 100,
            'catalog' => 'TEST-001',
            'category' => 'mrecs',
            'presale' => false,
            'b2b_enabled' => true,
            'direct_enabled' => true,
        ];

        $response = $this->post("items", $parameters, ['token' => $token->token])
            ->response
            ->getContent();

        $content = filter_var($response, FILTER_VALIDATE_BOOLEAN);

        $this->seeStatusCode(200);
        $this->assertTrue($content);
    }

    /**
     * /items [PUT]
     */
    public function test_should_update_existing_item()
    {
        // create a user/ token combo
        $token = factory('App\Models\Token')->create();

        $parameters = [
            'id' => 1,
            'artist' => 'Test Artist 2',
            'title' => 'Test Title 2',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'basic_cost' => 2001,
            'b2b_cost' => 1501,
            'images' => ['my_image.jpg'],
            'audio' => 'my_audio.mp3',
            'quantity_available' => 100,
            'catalog' => 'TEST-002',
            'category' => 'mrecs',
            'presale' => false,
            'b2b_enabled' => false,
            'direct_enabled' => true,
        ];

        $response = $this->put("items", $parameters, ['token' => $token->token])
            ->response
            ->getContent();

        $content = filter_var($response, FILTER_VALIDATE_BOOLEAN);

        $this->seeStatusCode(200);
        $this->assertTrue($content);
    }

    /**
     * /items [DELETE]
     */
    public function test_should_delete_existing_item()
    {
        // create a user/ token combo
        $token = factory('App\Models\Token')->create();

        $response = $this->delete("items/1", [], ['token' => $token->token])
            ->response
            ->getContent();

        $content = filter_var($response, FILTER_VALIDATE_BOOLEAN);

        $this->seeStatusCode(200);
        $this->assertTrue($content);
    }

    /**
     * /items/[id] [GET]
     */
    public function test_should_return_not_found_deleted_item()
    {
        $this->get("items/1");
        $this->seeStatusCode(404);
    }
}