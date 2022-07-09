<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    protected $table = 'absen';
	protected $guarded = [];
	public function absen_masuk(){
		return $this->hasOne(Absen_masuk::class, 'absen_id', 'id');
	}
	public function absen_pulang(){
		return $this->hasOne(Absen_pulang::class, 'absen_id', 'id');
	}
	public function ptk(){
		return $this->hasOne(Ptk::class, 'ptk_id', 'ptk_id');
	}
}
