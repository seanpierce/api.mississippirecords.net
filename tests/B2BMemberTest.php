<?php

class B2BMemberTest extends TestCase
{
    private $faker;

    public function __construct() {
        parent::__construct();
        $this->faker = Faker\Factory::create();
    }

    /**
     * @group b2bmember
     * /b2bmembers/request [POST]
     */
    public function test_should_create_b2b_request()
    {
        $parameters = [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'password_hash' => 'test123',
            'shipping_address' => $this->faker->streetAddress,
            'shipping_city' => $this->faker->streetAddress,
            'shipping_state' => $this->faker->stateAbbr,
            'shipping_zip' => $this->faker->postcode,
            'business_name' => 'My Cool Record Store',
        ];

        $response = $this->post('b2bmembers/request', $parameters)
            ->response
            ->getContent();

        $content = filter_var($response, FILTER_VALIDATE_BOOLEAN);

        $this->seeStatusCode(200);
        $this->assertTrue($content);
    }

    /**
     * @group b2bmember
     * /b2bmembers/approve [POST]
     */
    public function test_should_approve_b2b_member_request()
    {
        // create a user/ token combo
        $token = factory('App\Models\Token')->create();

        $parameters = [
            'id' => 1
        ];

        $response = $this->post('b2bmembers/approve', $parameters, ['token' => $token->token])
            ->response
            ->getContent();

        $content = filter_var($response, FILTER_VALIDATE_BOOLEAN);

        $this->seeStatusCode(200);
        $this->assertTrue($content);
    }
}