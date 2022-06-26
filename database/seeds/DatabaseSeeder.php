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
        $this->call([
            LaratrustSeeder::class,
            //factory(App\User::class, 10)->create(),
            WilayahSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
