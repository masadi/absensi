<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
class Pendaftar extends Model
{
    use Uuid;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'pendaftar_id';
    protected $table = 'pendaftar';
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function sekolah_pilihan(){
        return $this->hasMany(Sekolah_pilihan::class, 'pendaftar_id', 'pendaftar_id')->orderBy('pilihan_ke', 'ASC');
    }
    public function sekolah_pilihan_single(){
        return $this->hasOne(Sekolah_pilihan::class, 'pendaftar_id', 'pendaftar_id');
    }
    public function dokumen(){
        return $this->hasMany(Dokumen::class, 'pendaftar_id', 'pendaftar_id');
    }
    public function piagam(){
        return $this->hasMany(Piagam::class, 'pendaftar_id', 'pendaftar_id');
    }
    public function status(){
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
