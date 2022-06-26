<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
class Dokumen extends Model
{
    use Uuid;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'dokumen_id';
    protected $table = 'dokumen';
    protected $guarded = [];
    public function komponen(){
        return $this->belongsTo(Komponen::class, 'komponen_id', 'id');
    }
    public function pendaftar(){
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id', 'pendaftar_id');
    }
    public function status(){
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
    public function sekolah_pilihan(){
        return $this->belongsTo(Sekolah_pilihan::class, 'sekolah_pilihan_id', 'sekolah_pilihan_id');
    }
}
