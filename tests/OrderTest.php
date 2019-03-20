<?php

use App\Models\PasswordHash as PasswordHash;
use App\Models\Item as Item;

class OrderTest extends TestCase
{
    /**
     * @group orders
     * /orders/international [POST]
     */
    public function test_should_request_an_international_order()
    {
        $items = Item::paginate(3);

        $parameters = [
            'name' => 'Test Customer',
            'email' => 'testemail@example.com',
            'items' => $items
        ];

        $response = $this->post('orders/international', $parameters)
            ->response
            ->getContent();

        $content = filter_var($response, FILTER_VALIDATE_BOOLEAN);

        $this->seeStatusCode(200);
        $this->assertTrue($content);
    }
}