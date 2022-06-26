<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skor_prestasi extends Model
{
    protected $table = 'skor_prestasi';
    protected $guarded = [];
    public function jenis_kejuaraan(){
        return $this->belongsTo(Jenis_kejuaraan::class, 'jenis_kejuaraan_id', 'id');
    }
}
