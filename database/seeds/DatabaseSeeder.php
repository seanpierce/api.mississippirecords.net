<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->call('UsersTableSeeder');
		$this->call('B2BMemberRequestTableSeeder');
		$this->call('ItemsTableSeeder');
		$this->call('PostsTableSeeder');
    }
}
