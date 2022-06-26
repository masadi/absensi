<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Wilayah;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::LOGIN;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function showRegistrationForm()
    {
        $data_kecamatan = Wilayah::where('id_level_wilayah', 3)->where('mst_kode_wilayah', '052700')->get();
        return view('auth.register', compact('data_kecamatan'));
    }
    protected function validator(array $data)
    {
        $messages = [
            'name.required' => 'Nama Lengkap tidak boleh kosong',
            'nik.required' => 'NIK tidak boleh kosong',
            'nik.unique' => 'NIK terdeteksi sudah terdaftar. Silahkan login',
            'nik.min' => 'NIK minimal harus 16 angka',
            'nik.max' => 'NIK maksimal harus 16 angka',
            'kecamatan_id.required' => 'Kecamatan tidak boleh kosong',
            'desa_id.required' => 'Desa/Kelurahan tidak boleh kosong',
        ];
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'min:16', 'max:16', 'unique:users,username'],
            'kecamatan_id' => ['required'],
            'desa_id' => ['required'],
            //'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $random = Str::random(5);
        $user = User::create([
            'name' => $data['name'],
            'username' => $data['nik'],
            'email' => $data['nik'].'@disdik.sampangkab.go.id',
            'kecamatan_id' => $data['kecamatan_id'],
            'desa_id' => $data['desa_id'],
            'password' => Hash::make($random),
            'bentuk_pendidikan_id' => $data['bentuk_pendidikan_id'],
            'sandi' => $random,
        ]);
        if(!$user->hasRole('siswa')){
            $role = Role::where('name', 'siswa')->first();
            $user->attachRole($role);
        }
        return $user;
    }
    public function redirectTo()
    {
        return '/cetak';
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();
        if (auth()->user()->is_admin) {
            return '/admin/dashboard';
        } else if (auth()->user()->is_authenticated) {
            return '/app';
        } else {
            return '/home';
        }
    }
}
