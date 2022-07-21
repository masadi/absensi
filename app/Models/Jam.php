<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Jam extends Model
{
    use HasFactory;
    protected $table = 'jam';
	protected $guarded = [];
    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = $value;
        $this->attributes['slug'] = Str::of($value)->slug('-');
    }
    public function sekolah()
    {
        return $this->hasOne(Sekolah::class, 'sekolah_id', 'sekolah_id');
    }
    public function ptk(){
		return $this->hasMany(Jam_ptk::class, 'jam_id', 'id');
	}
    public function hari(){
		return $this->hasMany(Jam_hari::class, 'jam_id', 'id');
	}
}
