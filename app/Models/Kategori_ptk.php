<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori_ptk extends Model
{
    use HasFactory;
    protected $table = 'kategori_ptk';
	protected $guarded = [];
    
    public function Ptk()
    {
        return $this->hasOne(Ptk::class, 'ptk_id', 'ptk_id')->select('ptk_id', 'nama');
    }
}
