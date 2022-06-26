<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jalur extends Model
{
    protected $table = 'jalur';
    protected $guarded = [];
    public function komponen(){
        return $this->hasMany(Komponen::class, 'jalur_id', 'id');
    }
    public function sekolah_pilihan(){
        return $this->hasMany(Sekolah_pilihan::class, 'jalur_id', 'id')->with(['pendaftar.user']);
    }
    public function pagu(){
        return $this->hasOne(Pagu::class, 'jalur_id', 'id');
    }
}
