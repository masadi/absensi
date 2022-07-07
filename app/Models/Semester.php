<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    public $incrementing = false;
	protected $table = 'semester';
	protected $primaryKey = 'semester_id';
	protected $guarded = [];
}
