<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dpw extends Model
{
    use HasFactory;
    protected $table = 'dpw';
	protected $guarded = [];
    
    /*public function ketua()
    {
        return $this->belongsTo(User::class, 'ketua_id', 'id');
    }
    public function sekretaris()
    {
        return $this->belongsTo(User::class, 'sekretaris_id', 'id');
    }
    public function bendahara()
    {
        return $this->belongsTo(User::class, 'bendahara_id', 'id');
    }*/
}
