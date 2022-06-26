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
            //LaratrustSeeder::class,
            KategoriSeeder::class,
            RefSeeder::class,
            WilayahSeeder::class,
            SekolahSeeder::class,
            //PendaftarSeeder::class,
            OperatorSeeder::class,
        ]);
        /*$this->call(LaratrustSeeder::class);
        $this->call(KategoriSeeder::class);
        $this->call(RefSeeder::class);
        $this->call(WilayahSeeder::class);
        $this->call(SekolahSeeder::class);*/
    }
}
