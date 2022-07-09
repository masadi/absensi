<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen_pulang extends Model
{
    use HasFactory;
    protected $table = 'absen_pulang';
	protected $guarded = [];
	public function absen(){
		return $this->hasOne(Absen::class, 'id', 'absen_id');
	}
}
