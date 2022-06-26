<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenis_kejuaraan extends Model
{
    protected $table = 'jenis_kejuaraan';
    protected $guarded = [];
    
    public function skor_prestasi()
    {
        return $this->hasMany(Skor_prestasi::class, 'jenis_kejuaraan_id', 'id');
    }
}
