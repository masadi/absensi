<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota_rombel extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'string';
	protected $table = 'anggota_rombel';
	protected $primaryKey = 'peserta_didik_id';
	protected $guarded = [];
}
