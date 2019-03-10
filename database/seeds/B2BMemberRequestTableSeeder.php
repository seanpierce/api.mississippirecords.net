<?php

use Illuminate\Database\Seeder;
use App\Models\B2BMemberRequest as B2BMemberRequest;

class B2BMemberRequestTableSeeder extends Seeder
{
	private $faker;

	public function __construct()
	{
		$this->faker = Faker\Factory::create();
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->truncate_b2b_requests_table();
		$this->create_b2b_member_requests();
	}
	
	private function truncate_b2b_requests_table()
	{
		DB::table('b2b_member_requests')->truncate();
	}

	private function create_b2b_member_requests()
	{
		for ($i = 0; $i < 10; $i++)
		{
			B2BMemberRequest::create([
				'email' => $this->faker->safeEmail, 
				'name' => $this->faker->name,
				'password_hash' => password_hash('test123', PASSWORD_BCRYPT),
				'shipping_address' => $this->faker->streetAddress,
				'shipping_city' => $this->faker->streetAddress,
				'shipping_state' => $this->faker->stateAbbr,
				'shipping_zip' => $this->faker->postcode,
				'business_name' => $this->faker->company . ' Records',
			]);
		}
	}
}
