<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
	protected $guarded = [];
    public function jam(){
		return $this->hasOne(Jam::class, 'kategori_id', 'id');
        //return $this->hasMany(Jam::class, 'kategori_id', 'id');
	}
    public function sekolah()
    {
        return $this->hasOne(Sekolah::class, 'sekolah_id', 'sekolah_id');
    }
    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = $value;
        $this->attributes['slug'] = Str::of($value)->slug('-');
    }
    public function ptk(){
		return $this->hasMany(Kategori_ptk::class, 'kategori_id', 'id');
	}
    public function hari(){
		return $this->hasMany(Kategori_hari::class, 'kategori_id', 'id');
	}
}
