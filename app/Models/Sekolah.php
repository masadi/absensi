<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;
    public $incrementing = false;
	protected $table = 'sekolah';
	protected $primaryKey = 'sekolah_id';
	protected $guarded = [];
	public function ptk()
	{
		return $this->hasMany(Ptk::class, 'sekolah_id', 'sekolah_id');
	}
}
