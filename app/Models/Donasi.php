<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;
    protected $table = 'donasi';
	protected $guarded = [];
    
    public function dana()
    {
        return $this->hasMany(Dana::class, 'donasi_id', 'id');
    }
}
