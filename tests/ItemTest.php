<?php

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
}