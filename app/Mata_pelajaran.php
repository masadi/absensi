<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mata_pelajaran extends Model
{
    protected $table = 'mata_pelajaran';
    protected $guarded = [];
    public function nilai(){
        return $this->hasOne(Nilai::class, 'mata_pelajaran_id', 'id');
    }
}
