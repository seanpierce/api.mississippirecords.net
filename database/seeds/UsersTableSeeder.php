<?php

use Illuminate\Database\Seeder;
use App\Models\User as User;
use App\Models\PasswordHash as PasswordHash;

class UsersTableSeeder extends Seeder
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
		$this->make_admins();
		$this->make_b2b_members();
	}
	
	public function make_admins()
	{
		$email = 'admin@mississippirecords.com';
		DB::table('users')->insert([
            'name' => 'Sean Admin',
            'email' => $email,
			'class' => 'ADMIN',
			'shipping_address' => '1234 W Test St.',
			'shipping_city' => 'Portland',
			'shipping_state' => 'OR',
			'shipping_zip' => '97211',
			'business_name' => '',
			'approved_date' => date("Y-m-d H:i:s")
		]);
		
		$user = User::where('email', $email)->first();
		$password_hash = new PasswordHash;
		$password_hash->password_hash = password_hash('test123', PASSWORD_BCRYPT);
		$password_hash->user_id = $user->id;
		$password_hash->save();
	}

	public function make_b2b_members()
	{
		for($i = 0; $i < 10; $i++) {
			$email = $this->faker->safeEmail;

			DB::table('users')->insert([
				'name' => $this->faker->name,
				'email' => $email,
				'class' => 'B2B',
				'shipping_address' => $this->faker->streetAddress,
				'shipping_city' => $this->faker->streetAddress,
				'shipping_state' => $this->faker->stateAbbr,
				'shipping_zip' => $this->faker->postcode,
				'business_name' => $this->faker->company . ' Records',
				'approved_date' => date("Y-m-d H:i:s")
			]);

			$user = User::where('email', $email)->first();
			$password_hash = new PasswordHash;
			$password_hash->password_hash = password_hash('test123', PASSWORD_BCRYPT);
			$password_hash->user_id = $user->id;
			$password_hash->save();
		}
	}
}
