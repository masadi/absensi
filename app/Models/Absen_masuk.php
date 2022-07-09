<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen_masuk extends Model
{
    use HasFactory;
    protected $table = 'absen_masuk';
	protected $guarded = [];
	public function absen(){
		return $this->hasOne(Absen::class, 'id', 'absen_id');
	}
}
