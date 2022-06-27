<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;
    protected $table = 'kegiatan';
	protected $guarded = [];
    public function getWaktuAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }
    public function kehadiran()
    {
        return $this->hasOneThrough(
            User::class,
            Kehadiran::class,
            'kegiatan_id', // Foreign key on the cars table...
            'id', // Foreign key on the owners table...
            'id', // Local key on the mechanics table...
            'user_id' // Local key on the cars table...
        );
        return $this->hasOneThrough(Kehadiran::class, Kegiatan::class);
    }
}
