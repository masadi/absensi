<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function mapel(){
        return $this->belongsTo(Mata_pelajaran::class, 'mata_pelajaran_id', 'id');
    }
}
