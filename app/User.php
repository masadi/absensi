<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use App\HelperModel;
use App\Traits\Uuid;
use Carbon\Carbon;

class User extends Authenticatable
{
    use LaratrustUserTrait, Notifiable, Uuid;
    public $incrementing = false;
    protected $keyType = 'string';
	//protected $table = 'instrumens';
	protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = [
        //'name', 'email', 'password', 'username',
    //];
    protected $guarded = [];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function sekolah(){
        return $this->belongsTo('App\Sekolah', 'sekolah_id', 'sekolah_id');
    }
    public function kecamatan(){
        return $this->belongsTo('App\Wilayah', 'kecamatan_id', 'kode_wilayah');
    }
    public function desa(){
        return $this->belongsTo('App\Wilayah', 'desa_id', 'kode_wilayah');
    }
    public function pendaftar(){
        return $this->belongsTo('App\Pendaftar', 'user_id', 'user_id');
    }
    public function agama(){
        return $this->belongsTo('App\Agama', 'agama_id', 'id');
    }
    public function jenis_tinggal(){
        return $this->belongsTo('App\Jenis_tinggal', 'jenis_tinggal_id', 'id');
    }
    public function getKebutuhanKhususAttribute($value)
    {
        return unserialize($value);
    }
    public function nilai(){
        return $this->hasMany(Nilai::class, 'user_id', 'user_id');
    }
    public function getUsiaAttribute()
    {
        //$years = Carbon::parse($this->tanggal_lahir)->age;
        //$years = Carbon::parse($this->tanggal_lahir)->diff(Carbon::now())->format('%y Tahun, %m Bulan dan %d Hari');
        $years = Carbon::parse($this->tanggal_lahir)->diff(date('Y-m-d H:i:s', strtotime('2022-07-01')))->format('%y Tahun, %m Bulan dan %d Hari');
        return "{$years}";
    }
    public function getAge(){
        return $this->getUsiaAttribute->diff(Carbon::now())
             ->format('%y years, %m months and %d days');
    }
    public function getUsiaAgoAttribute()
    {
        //$years = Carbon::parse($this->tanggal_lahir)->diff(Carbon::now())->format('%y years, %m months and %d days');
        $years = Carbon::parse($this->tanggal_lahir)->diffInDays();
        return "{$years}";
    }
}
