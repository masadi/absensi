<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
//use Yajra\Acl\Traits\HasRole;
use Yajra\Acl\Traits\HasRoleAndPermission;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    //use HasRole;
    use HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];
    /*protected $fillable = [
        'name',
        'email',
        'password',
    ];*/
    public function getTanggalLahirAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
    /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dpw()
    {
        return $this->belongsTo(Dpw::class, 'dpw_id', 'id');
    }
    public function ketua()
    {
        return $this->belongsTo(Dpw::class, 'id', 'ketua_id');
    }
    public function sekretaris()
    {
        return $this->belongsTo(Dpw::class, 'id', 'sekretaris_id');
    }
    public function bendahara()
    {
        return $this->belongsTo(Dpw::class, 'id', 'bendahara_id');
    }
}
