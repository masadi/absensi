<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dana extends Model
{
    use HasFactory;
    protected $table = 'dana';
	protected $guarded = [];
    public function donasi()
    {
        return $this->belongsTo(Donasi::class, 'donasi_id', 'id');
    }
}
