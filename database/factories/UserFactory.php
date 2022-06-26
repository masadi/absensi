<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker, array $arguments = []) {
    //$rand = App\HelperModel::str_rand();
    $rand = $faker->nik();
    $tanggal_sd = App\HelperModel::randomDate('2016-07-01', '2016-12-31');
    $tanggal_smp = App\HelperModel::randomDate('2007-07-01', '2007-12-31');
    $arr = [5,6];
    $jenis_kelamin = ['L', 'P'];
    shuffle($arr);
    shuffle($jenis_kelamin);
    $wilayah = App\Wilayah::with('parrentRecursive')->find('052601AA');
    return [
        'name' => $faker->name,
        'username' => $rand,
        'email' => $faker->email,//$rand.'@disdik.sampangkab.go.id',
        'email_verified_at' => now(),
        'password' => Hash::make($rand), // password
        'bentuk_pendidikan_id' => $arguments['bentuk_pendidikan_id'],
        'sandi' => $rand,
        'jenis_kelamin' => $jenis_kelamin[0],
        'wna' => 0,
		'negara_id' => $wilayah->negara_id,
		'provinsi_id' => $wilayah->parrentRecursive->parrentRecursive->parrentRecursive->kode_wilayah,
		'kabupaten_id' => $wilayah->parrentRecursive->parrentRecursive->kode_wilayah,
		'kecamatan_id' => $wilayah->parrentRecursive->kode_wilayah,
		'desa_id' => $wilayah->kode_wilayah,
		'provinsi' => $wilayah->parrentRecursive->parrentRecursive->parrentRecursive->nama,
		'kabupaten' => $wilayah->parrentRecursive->parrentRecursive->nama,
		'kecamatan' => $wilayah->parrentRecursive->nama,
		'desa' => $wilayah->nama,
		'nomor_hp' => str_replace(' ', '', $faker->phoneNumber()),
		'alamat' => 'alamat',
		'rt' => 123,
		'rw' => 123,
		'nama_ortu' => $faker->name,
		'tempat_lahir' => 'Sampang',
		'tanggal_lahir' => ($arr[0] == 5) ? $tanggal_sd : $tanggal_smp,
		'jenis_tinggal_id' => 1,
		'agama_id' => 1,
    ];
});
$factory->afterCreating(User::class, function ($user, $faker) {
    $role = App\Role::where('name', 'siswa')->first();
    $user->attachRole($role);
    $count_pendaftar = App\Pendaftar::where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->where('user_id', '<>', $user->user_id)->count() + 1;
    $jenjang = ($user->bentuk_pendidikan_id == 5) ? 'SD' : 'SMP';
    $nomor_pendaftaran = $jenjang.'-'.str_pad($count_pendaftar,5,0,STR_PAD_LEFT).'-'.date('d-m-Y');
    $all_data = App\Pendaftar::create(
        [
            'user_id' => $user->user_id,
            'nomor_pendaftaran' => $nomor_pendaftaran,
            'bentuk_pendidikan_id' => $user->bentuk_pendidikan_id,
            'jenis_kelamin' => $user->jenis_kelamin,
        ]
    );
    $sekolah = App\Sekolah::where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->where('bludak', 1)->first();
    $jalur = App\Jalur::where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->inRandomOrder()->first();
    if($sekolah){
        $sekolah_pilihan = App\Sekolah_pilihan::updateOrCreate(
            [
                'pendaftar_id' => $all_data->pendaftar_id,
                'sekolah_id' => $sekolah->sekolah_id,
            ],
            [
                'jalur_id' => $jalur->id,
                'pilihan_ke' => 1,
                'tampil' => 1,
            ]
        );
    }
});
