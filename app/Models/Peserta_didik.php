<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta_didik extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'string';
	protected $table = 'peserta_didik';
	protected $primaryKey = 'peserta_didik_id';
	protected $guarded = [];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function sekolah()
    {
        return $this->hasOne(Sekolah::class, 'sekolah_id', 'sekolah_id');
    }
    public function absen()
    {
        return $this->hasOne(Absen::class, 'peserta_didik_id', 'peserta_didik_id');
    }
    public function absen_masuk()
    {
        return $this->hasMany(Absen::class, 'peserta_didik_id', 'peserta_didik_id')->where('jenis_absen_id', 1);
    }
    public function absen_pulang()
    {
        return $this->hasMany(Absen::class, 'peserta_didik_id', 'peserta_didik_id')->where('jenis_absen_id', 2);
    }
    public function anggota_rombel()
    {
        return $this->hasOne(Anggota_rombel::class, 'peserta_didik_id', 'peserta_didik_id');
    }
    public function kelas(){
        return $this->hasOneThrough(
            Rombongan_belajar::class,
            Anggota_rombel::class,
            'peserta_didik_id', // Foreign key on the cars table...
            'rombongan_belajar_id', // Foreign key on the owners table...
            'peserta_didik_id', // Local key on the mechanics table...
            'rombongan_belajar_id' // Local key on the cars table...
        );
    }
}
