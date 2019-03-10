<?php

use Illuminate\Database\Seeder;
use App\Models\Item as Item;

class ItemsTableSeeder extends Seeder
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
		$this->truncate_items_table();
		$this->create_items();
	}
	
	public function truncate_items_table()
	{
		DB::table('items')->truncate();
	}

	public function create_items()
	{
		$cat[0] = 'mrecs';
		$cat[1] = 'distro';
		$cat[2] = 'mcass';
		$cat[3] = 'dcass';
		$cat[4] = 'other';

		$bool[0] = false;
		$bool[1] = true;

		for ($i = 0; $i < 20; $i++) 
		{
			$item = new Item;
			$item->artist = $this->faker->firstNameFemale . ' ' . $this->faker->lastName;
			$item->title = $this->faker->realText($maxNbChars = 20, $indexSize = 2);
			$item->description = $this->faker->realText($maxNbChars = 200, $indexSize = 2);
			$item->basic_cost = $this->faker->numberBetween($min = 1000, $max = 4000);
			$item->b2b_cost = $this->faker->numberBetween($min = 800, $max = 4000);
			$item->images = 'https://picsum.photos/300/300';
			$item->audio = '';
			$item->quantity_available = $this->faker->numberBetween($min = 10, $max = 100);
			$item->catalog = $this->faker->randomLetter 
				. $this->faker->randomLetter 
				. $this->faker->randomLetter 
				. '-' 
				. $this->faker->numberBetween($min = 0, $max = 100);
			$item->category = $cat[$this->faker->numberBetween($min = 0, $max = 4)];
			$item->presale = false;
			$item->b2b_enabled = $bool[$this->faker->numberBetween($min = 0, $max = 1)];
			$item->direct_enabled = $bool[$this->faker->numberBetween($min = 0, $max = 1)];

			$item->save();
		}
	}
}
