<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Pagu extends Model
{
    use Uuid;
    public $incrementing = false;
    protected $keyType = 'string';
	protected $table = 'pagu';
	protected $primaryKey = 'pagu_id';
    protected $guarded = [];

    public function sekolah(){
        return $this->belongsTo(Sekolah::class, 'sekolah_id', 'sekolah_id');
    }
    public function jalur(){
        return $this->belongsTo(Jalur::class, 'jalur_id', 'id');
    }
}
