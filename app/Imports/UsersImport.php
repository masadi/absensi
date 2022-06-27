<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class UsersImport implements ToModel, WithUpserts, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $hitung = User::role('alumni')->count();
        $urut = Str::padLeft($hitung, 6, '0');
        $user = User::updateOrCreate(
            [
                'email' => $row['email'],
            ],
            [
                'name' => $row['nama_lengkap'],
                'password' => Hash::make($row['password_login']),
                'tempat_lahir' => $row['tempat_lahir'],
                'tanggal_lahir' => $this->transformDate($row['tanggal_lahir']),
                'alamat_rumah' => $row['alamat_rumah'],
                'alamat_domisili' => $row['alamat_domisili'],
                'nomor_handphone' => $row['nomor_teleponhp'],
                'pekerjaan' => $row['pekerjaan'],
                'nik' => $row['nik'],
                'tahun_masuk' => $row['tahun_masuk'],
                'tahun_lulus' => $row['tahun_lulus'],
                'whatsapp' => $row['nomor_whatsapp'],
                'facebook' => $row['akun_facebook'],
                'instagram' => $row['akun_instagram'],
                'youtube' => $row['akun_youtube'],
                'tiktok' => $row['akun_tiktok'],
                'twitter' => $row['akun_twitter'],
            ]
        );
        $user->fresh();
        $user->nomor_induk = $user->tahun_lulus.$urut;
        $user->save();
        $user->assignRole('alumni');
        return $user;
    }
    public function uniqueBy()
    {
        return 'email';
    }
    public function transformDate($value, $format = 'Y-m-d')
{
    try {
        return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    } catch (\ErrorException $e) {
        return \Carbon\Carbon::createFromFormat($format, $value);
    }
}
}
