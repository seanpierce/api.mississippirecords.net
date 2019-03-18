<?php

use App\Models\Token as Token;

class ItemTest extends TestCase
{
    /**
     * /items [GET]
     */
    public function testShouldReturnAllItems()
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
    public function testShouldReturnSingleItem()
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
}