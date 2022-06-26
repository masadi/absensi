<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $username;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
    }
    public function username()
    {
        return $this->username;
    }
    public function findUsername()
    {
        $login = request()->input('email');
		$messages = [
			'email.required' => 'Email/NPSN/Nama Pengguna tidak boleh kosong',
		];
		$validator = Validator::make(request()->all(), [
			'email' => 'required|exists:users,username',
		 ],
		$messages
        );
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $auth = request()->merge([$fieldType => $login]);
        return $fieldType;
    }
    public function login(Request $request)
    {
        //dd($request->all());
        if ($request->has('username')) {
            $credentials = ['username' => $request->username, 'password' => $request->password];//$request->only('username', 'password');
        } else {
            $credentials = ['email' => $request->email, 'password' => $request->password];//$request->only('email', 'password');
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            /*if($user->hasRole('siswa')){
                Auth::logout();
                return redirect()->intended('/login')->withErrors('Login aplikasi sementara sedang ditutup');
                //return redirect()->intended('/login')->withErrors(['email', 'Login aplikasi sementara sedang ditutup']);
            } else {
                return redirect()->intended('/app/beranda');
            }*/
            return redirect()->intended('/app/beranda');
            // Authentication passed...
        } else {
            return redirect()->intended('/login')->withError('Akun tidak aktif.');
        }
    }
}
