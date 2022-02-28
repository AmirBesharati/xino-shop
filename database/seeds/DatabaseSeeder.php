<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*$this->call([
            UserSeeder::class,
            ProductSeeder::class,
        ]);*/
        factory(\App\Models\User::class, 50)->create();
        factory(\App\Models\Product::class, 500)->create();

    }
}
