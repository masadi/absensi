<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komponen extends Model
{
    protected $table = 'komponen';
    protected $guarded = [];
    public function dokumen(){
        return $this->hasOne(Dokumen::class, 'komponen_id', 'id');
    }
}
