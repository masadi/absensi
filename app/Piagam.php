<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Piagam extends Model
{
    protected $table = 'piagam';
    protected $guarded = [];
    public function tingkat_prestasi(){
        return $this->belongsTo(Tingkat_prestasi::class, 'tingkat_prestasi_id', 'id');
    }
    public function pendaftar(){
        return $this->belongsTo(Pendaftar::class, 'user_id', 'user_id');
    }
    public function status(){
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
    public function skor_prestasi(){
        return $this->belongsTo(Skor_prestasi::class, 'skor_prestasi_id', 'id');
    }
}
