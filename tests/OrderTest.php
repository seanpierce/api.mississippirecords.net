<?php

use App\Models\PasswordHash as PasswordHash;
use App\Models\Item as Item;
use App\Models\SubModels\OrderConfirmationItem as OrderConfirmationItem;

class OrderTest extends TestCase
{
    private $faker;

    public function __construct() {
        parent::__construct();
        $this->faker = Faker\Factory::create();
    }

    /**
     * @group orders
     * /orders/international [POST]
     */
    public function test_should_request_an_international_order()
    {
        $items = $this->create_test_order_confirmation_items();

        $parameters = [
            'name' => 'Test Customer',
            'email' => 'testemail@example.com',
            'items' => $items,
        ];

        $response = $this->post('orders/international', $parameters)
            ->response
            ->getContent();

        $content = filter_var($response, FILTER_VALIDATE_BOOLEAN);

        $this->seeStatusCode(200);
        $this->assertTrue($content);
    }

    private function create_test_order_confirmation_items()
    {
        $items = [];

        for ($i = 0; $i < 3; $i ++)
        {
            $item = new OrderConfirmationItem;
            $item->id = 0;
            $item->artist = $this->faker->firstNameFemale . ' ' . $this->faker->lastName;
            $item->title = $this->faker->realText($maxNbChars = 20, $indexSize = 2);
            $item->cost = $this->faker->numberBetween($min = 1000, $max = 3000);
            $item->quantity_ordered = $this->faker->numberBetween($min = 10, $max = 30);
            $item->quantity_available = 1000;
            $item->available = true;
            
            $item->subtotal = $item->quantity_ordered * $item->cost;

            array_push($items, $item);
        }
        return $items;
    }
}