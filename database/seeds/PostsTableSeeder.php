<?php

use Illuminate\Database\Seeder;
use App\Models\Post as Post;

class PostsTableSeeder extends Seeder
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
		$this->truncate_posts_table();
		$this->create_posts();
	}
	
	private function truncate_posts_table()
	{
		DB::table('posts')->truncate();
	}

	private function create_posts()
	{
		Post::create([
			'page' => 'links',
			'text' => $this->faker->realText($maxNbChars = 200, $indexSize = 2),
			'link' => $this->faker->url,
		]);

		Post::create([
			'page' => 'shipping',
			'text' => $this->faker->realText($maxNbChars = 400, $indexSize = 2),
		]);

		Post::create([
			'page' => 'shipping-b2b',
			'text' => $this->faker->realText($maxNbChars = 400, $indexSize = 2),
		]);

		Post::create([
			'page' => 'news',
			'text' => $this->faker->realText($maxNbChars = 400, $indexSize = 2),
			'image' => 'https://picsum.photos/300/300',
		]);

		Post::create([
			'page' => 'how-to',
			'text' => $this->faker->realText($maxNbChars = 400, $indexSize = 2),
		]);

		Post::create([
			'page' => 'discog',
			'text' => $this->faker->realText($maxNbChars = 600, $indexSize = 2),
		]);
	}
}
