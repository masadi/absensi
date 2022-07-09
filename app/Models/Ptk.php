<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ptk extends Model
{
    use HasFactory;
    public $incrementing = false;
	protected $table = 'ptk';
	protected $primaryKey = 'ptk_id';
	protected $guarded = [];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function sekolah()
    {
        return $this->hasOne(Sekolah::class, 'sekolah_id', 'sekolah_id');
    }
    public function absen_masuk()
    {
        return $this->hasMany(Absen::class, 'ptk_id', 'ptk_id')->where('jenis_absen_id', 1);
    }
    public function absen_pulang()
    {
        return $this->hasMany(Absen::class, 'ptk_id', 'ptk_id')->where('jenis_absen_id', 2);
    }
}
