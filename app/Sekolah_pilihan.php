<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

class Sekolah_pilihan extends Model
{
    use SoftDeletes;
    use Uuid;
    public $incrementing = false;
    protected $keyType = 'string';
	protected $table = 'sekolah_pilihan';
	protected $primaryKey = 'sekolah_pilihan_id';
    protected $guarded = [];
    public function sekolah(){
        return $this->belongsTo(Sekolah::class, 'sekolah_id', 'sekolah_id');
    }
    public function jenis_prestasi(){
        return $this->belongsTo(Jenis_prestasi::class, 'jenis_prestasi_id', 'id');
    }
    public function jalur(){
        return $this->belongsTo(Jalur::class, 'jalur_id', 'id');
    }
    public function pendaftar(){
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id', 'pendaftar_id');
    }
    public function verifikator(){
        return $this->belongsTo(User::class, 'verifikator_id', 'user_id');
    }
    public function status(){
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
    public function dokumen(){
        return $this->hasMany(Dokumen::class, 'pendaftar_id', 'pendaftar_id');
    }
    //public function getNilaiAkhirAttribute()
    //{
        //return $this->nilai + $this->titipan;
        //return "{$this->titipan}";
    //}
}
