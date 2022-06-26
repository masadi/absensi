<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use App\User;
use App\Role;
use App\Wilayah;
use App\Negara;
use App\Agama;
use App\HelperModel;
use App\Kebutuhan_khusus;
use App\Mata_pelajaran;
use App\Nilai;
use App\Jenis_tinggal;
use App\Tingkat_prestasi;
use App\Piagam;
use App\Sekolah_pilihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\MatchOldPassword;
use Carbon\Carbon;
use File;
use Image;

class UsersController extends Controller
{
	public function __construct()
    {
        $this->path = public_path('images');
		$this->dimensions = ['245', '300', '500'];
    }
    public function index(Request $request, $query) {
		$function = 'get_'.str_replace('-', '_', $query);
        return $this->{$function}($request);
        /**/
    }
	public function get_list($request){
		$users = User::where(function($query){
			$query->whereRoleIs(['siswa']);
            if(request()->sekolah_id){
                $query->where('sekolah_id', request()->sekolah_id);
            }
			if(request()->bentuk_pendidikan_id){
                $query->where('bentuk_pendidikan_id', request()->bentuk_pendidikan_id);
            }
        })->orderBy(request()->sortby, request()->sortbydesc)
            //JIKA Q ATAU PARAMETER PENCARIAN INI TIDAK KOSONG
            ->when(request()->q, function($posts) {
                //MAKA FUNGSI FILTER AKAN DIJALANKAN
                $posts = $posts->where('name', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('email', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('username', 'LIKE', '%' . request()->q . '%');
        })->paginate(request()->per_page); //KEMUDIAN LOAD PAGINATIONNYA BERDASARKAN LOAD PER_PAGE YANG DIINGINKAN OLEH USER
        return response()->json(['status' => 'success', 'data' => $users]);
	}
	public function get_list_operator($request){
		$users = User::where(function($query){
			$query->whereRoleIs('sekolah');
			$query->whereHas('sekolah');
			if(request()->bentuk_pendidikan_id){
                $query->where('bentuk_pendidikan_id', request()->bentuk_pendidikan_id);
            }
        })->orderBy(request()->sortby, request()->sortbydesc)
            //JIKA Q ATAU PARAMETER PENCARIAN INI TIDAK KOSONG
            ->when(request()->q, function($posts) {
                //MAKA FUNGSI FILTER AKAN DIJALANKAN
                $posts = $posts->where('name', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('email', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('username', 'LIKE', '%' . request()->q . '%');
        })->with(['sekolah'])->paginate(request()->per_page); //KEMUDIAN LOAD PAGINATIONNYA BERDASARKAN LOAD PER_PAGE YANG DIINGINKAN OLEH USER
        return response()->json(['status' => 'success', 'data' => $users]);
	}
	public function get_negara(Request $request){
		$all_data = Negara::select('negara_id as value', 'nama')->where(function($query) use ($request){
			if(!is_null($request->negara)){
				$query->where('luar_negeri', $request->negara);
			}
		})->get();
		$open = strtotime(date('Y-m-d')) <= strtotime('2021-06-26');
        return response()->json(['open' => $open, 'status' => 'success', 'data' => $all_data]);
	}
	public function get_provinsi(Request $request){
		$all_data = Wilayah::select('kode_wilayah as value', 'nama')->where('id_level_wilayah', 1)->where('negara_id', $request->negara_id)->get();
        return response()->json(['status' => 'success', 'data' => $all_data]);
	}
	public function get_kabupaten(Request $request){
		$all_data = Wilayah::select('kode_wilayah as value', 'nama')->where('id_level_wilayah', 2)->where('mst_kode_wilayah', $request->provinsi_id)->get();
        return response()->json(['status' => 'success', 'data' => $all_data]);
	}
	public function get_kecamatan(Request $request){
		//'052700'
		$all_data = Wilayah::select('kode_wilayah as value', 'nama')->where('id_level_wilayah', 3)->where('mst_kode_wilayah', $request->kabupaten_id)->get();
        return response()->json(['status' => 'success', 'data' => $all_data]);
	}
	public function get_desa(Request $request){
        $all_data = Wilayah::select('kode_wilayah as value', 'nama')->where('id_level_wilayah', 4)->where('mst_kode_wilayah', $request->kecamatan_id)->get();
        return response()->json(['status' => 'success', 'data' => $all_data]);
    }
	public function get_agama(Request $request){
        $all_data = Agama::select('id as value', 'nama')->get();
        return response()->json(['status' => 'success', 'data' => $all_data]);
    }
	public function get_kebutuhan_khusus(Request $request){
        $all_data = Kebutuhan_khusus::select('id as value', 'nama')->get();
        return response()->json(['status' => 'success', 'data' => $all_data]);
    }
	public function get_jenis_tinggal(Request $request){
        $all_data = Jenis_tinggal::select('id as value', 'nama')->get();
        return response()->json(['status' => 'success', 'data' => $all_data]);
    }
	public function get_koordinat($request){
		$user = User::with(['desa'])->find($request->user_id);
		$geojson = NULL;
		if($user->hasRole('siswa')){
			$geojson = File::get(public_path('geojson').'/'.trim($user->kecamatan->kode_wilayah).'.geojson');
			$geojson = json_decode($geojson);
		}
		return response()->json(['status' => 'success', 'data' => $user, 'geojson' => $geojson]);
	}
	public function simpan_data(Request $request){
		$user = User::find($request->user_id);
		$user->lintang = $request->lintang;
		$user->bujur = $request->bujur;
		$user->save();
	}
    public function create(Request $request)
    {

         Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

	}
	public function store(Request $request){
		$messages = [
			'name.required'	=> 'Nama Lengkap tidak boleh kosong',
			'email.email'	=> 'Email Tidak Valid',
			'email.unique'	=> 'Email sudah terdaftar di database',
			/*'current_password.nullable' => 'Please enter current password',
    		'password.nullable' => 'Please enter password',
			'email.required'	=> 'Email tidak boleh kosong',
			'password.required_with_all' => 'Kata sandi baru tidak boleh kosong',
			'password_confirmation.same' => 'Konfirmasi sandi tidak sama dengan sandi baru',*/
			'token.required' => 'Token tidak boleh kosong',
			'token.unique' => 'Token sudah terdaftar di database',
		];
		$validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			//'password' => ['required', 'string', 'min:8', 'confirmed'],
			'token' => ['required', 'string', 'max:255', 'unique:users,username'],
        ],
		$messages
		)->validate();
		$username = strtolower($request->token);
		$username = str_replace(' ', '', $username);
		$username = trim($username);
        $user =  User::create([
            'name' => $request['name'],
			'email' => $request['email'],
			'username' => $username,
			'password' => Hash::make($username),
			'token' => strtolower($request->token),
		]);
		if(!$user->hasRole('penjamin_mutu')){
			$role = Role::where('name', 'penjamin_mutu')->first();
			$user->attachRole($role);
		}
		$response = [
			'title' => 'Berhasil',
			'text' => 'Verifikator berhasil ditambahkan',
			'icon' => 'success',
		];
		return response()->json($response);
	}
    public function profile(Request $request){
        $data = User::with(['desa.parent', 'sekolah'])->find($request->user_id);
		$maps = NULL;
		$desa = NULL;
		if($data->desa && !$data->bujur){
			$desa = $data->desa.' '.$data->kecamatan.' '.$data->kabupaten;
			//$desa = 'MONUMEN TRUNOJOYO SAMPANG';
			$response = Http::withOptions([
				'verify' => false
			])->get('https://maps.googleapis.com/maps/api/geocode/json', [
				'address' => urlencode($desa),
				'key' => 'AIzaSyBjh5tV4UCBXDFtjkPc3lO4uiXB9yzpohI',
				//AIzaSyBkax_ntJg_RiyRU8XooKtegBFsKqqxvwk
			]);
			$maps = $response->json();
		}
		$kunci = Sekolah_pilihan::whereKunci(1)->whereHas('pendaftar', function($query){
			$query->where('user_id', request()->user_id);
		})->first();
        return response()->json(['status' => 'success', 'data' => $data, 'maps' => $maps, 'desa' => $desa, 'kunci' => $kunci]);
    }
	public function get_update_peta(Request $request){
		$user = User::findOrFail($request->user_id);
		$messages = [
			'lintang.required' => 'Lintang tidak boleh kosong',
			'bujur.required' => 'Bujur tidak boleh kosong',
		];
		$validator = Validator::make(request()->all(), [
			'lintang'		=> 'required',
			'bujur'			=> 'required',
		],
		$messages
		)->validate();
		if($user){
			$user->lintang = $request->lintang;
			$user->bujur = $request->bujur;
			if($user->save()){
				$response = [
					'icon' => 'success', 
					'title' => 'Berhasil', 
					'text' => 'Lokasi penggguna berhasil diperbaharui'
				];
			} else {
				$response = [
					'icon' => 'danger', 
					'title' => 'Gagal', 
					'text' => 'Lokasi penggguna gagal diperbaharui'
				];
			}
		} else {
			$response = [
				'icon' => 'danger', 
				'title' => 'Gagal', 
				'text' => 'Data Pengguna tidak ditemukan'
			];
		}
		return response()->json($response);
	}
	public function get_update_password(Request $request){
		$user = User::findOrFail($request->user_id);
		$messages = [
			'current_password.required' => 'Kata sandi saat ini tidak boleh kosong',
			'password.min' => 'Kata sandi minimal terdiri dari 8 karakter',
			'password.required_with_all' => 'Kata sandi baru tidak boleh kosong',
			'password.confirmed' => 'Konfirmasi kata sandi salah',
			'password_confirmation.confirmed' => 'Konfirmasi kata sandi salah',
			'password_confirmation.required_with_all' => 'Konfirmasi kata sandi tidak boleh kosong',
		];
		$validator = Validator::make(request()->all(), [
			'current_password'		=> ['required', new MatchOldPassword($request->user_id)],
			'password'				=> 'nullable|required_with_all:current_password,email|min:8|confirmed',
			'password_confirmation' => 'required_with_all:password',
		],
		$messages
		)->validate();
		if($user){
			if(Hash::check($request->current_password, $user->password)){       
				$user->password = Hash::make($request->password);
			}
			if($user->save()){
				$response = [
					'icon' => 'success', 
					'title' => 'Berhasil', 
					'text' => 'Kata Sandi penggguna berhasil diperbaharui'
				];
			} else {
				$response = [
					'icon' => 'danger', 
					'title' => 'Gagal', 
					'text' => 'Kata Sandi penggguna gagal diperbaharui'
				];
			}
		} else {
			$response = [
				'icon' => 'danger', 
				'title' => 'Gagal', 
				'text' => 'Data Pengguna tidak ditemukan'
			];
		}
		return response()->json($response);
	}
	public function get_tambah(Request $request){
		$messages = [
			'image.mimes'	=> 'Foto profile harus berekstensi jpg/png/jpeg',
			'image.image'	=> 'Foto profile harus berekstensi jpg/png/jpeg',
			'nik.required' => 'NIK tidak boleh kosong',
            'nik.unique' => 'NIK terdeteksi sudah terdaftar. Silahkan login',
            'nik.min' => 'NIK minimal harus 16 angka',
            'nik.max' => 'NIK maksimal harus 16 angka',
			'wna.required' => 'Warga Negara tidak boleh kosong',
			'negara_id.required' => 'Negara tidak boleh kosong',
			'provinsi_id.required' => 'Provinsi tidak boleh kosong',
			'kabupaten_id.required' => 'Kabupaten tidak boleh kosong',
			'kecamatan_id.required' => 'Kecamatan tidak boleh kosong',
			'desa_id.required' => 'Desa/Kelurahan tidak boleh kosong',
			'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
			'nomor_hp.required' => 'Nomor HP tidak boleh kosong',
			'name.required' => 'Nama Lengkap tidak boleh kosong',
			'alamat.required' => 'Alamat tidak boleh kosong',
			'rt.required' => 'RT tidak boleh kosong',
			'rw.required' => 'RW tidak boleh kosong',
			'tempat_lahir.required' => 'Tempat Lahir tidak boleh kosong',
			'tanggal_lahir.required' => 'Tanggal Lahir tidak boleh kosong',
			'agama_id.required' => 'Agama tidak boleh kosong',
			'password.required' => 'Password tidak boleh kosong',
		];
		$validator = Validator::make(request()->all(), [
			'image'					=> 'nullable|image|mimes:jpg,png,jpeg',
			'name'					=> 'required',
			'wna'					=> 'required',
			'negara_id'				=> 'required',
			'provinsi_id'			=> 'required',
			'kabupaten_id'			=> 'required',
			'agama_id'				=> 'required',
			'kecamatan_id'			=> 'required',
			'desa_id'				=> 'required',
			'nomor_hp'				=> 'required',
			'jenis_kelamin'			=> 'required',
			'alamat'				=> 'required',
			'rt'					=> 'required',
			'rw'					=> 'required',
			'tempat_lahir'			=> 'required',
			'tanggal_lahir'			=> 'required',
			'password'			=> 'required',
			'nik'					=> 'required|min:16|max:16|unique:users,username',
		],
		$messages
		)->validate();
		$provinsi = Wilayah::find($request->provinsi_id);
		if($provinsi){
			$provinsi_id = $request->provinsi_id;
			$nama_provinsi = $provinsi->nama;
		} else {
			$provinsi_id = NULL;
			$nama_provinsi = $request->provinsi_id;
		}
		$kabupaten = Wilayah::find($request->kabupaten_id);
		if($kabupaten){
			$kabupaten_id = $request->kabupaten_id;
			$nama_kabupaten = $kabupaten->nama;
		} else {
			$kabupaten_id = NULL;
			$nama_kabupaten = $request->kabupaten_id;
		}
		$kecamatan = Wilayah::find($request->kecamatan_id);
		if($kecamatan){
			$kecamatan_id = $request->kecamatan_id;
			$nama_kecamatan = $kecamatan->nama;
		} else {
			$kecamatan_id = NULL;
			$nama_kecamatan = $request->kecamatan_id;
		}
		$desa = Wilayah::find($request->desa_id);
		if($desa){
			$desa_id = $request->desa_id;
			$nama_desa = $desa->nama;
		} else {
			$desa_id = NULL;
			$nama_desa = $request->desa_id;
		}
		$nama_ortu = $request->nama_ortu;
		$wna = $request->wna;
		$negara_id = $request->negara_id;
		$agama_id = $request->agama_id;
		$jenis_tinggal_id = $request->jenis_tinggal_id;
		$alamat = $request->alamat;
		$rt = $request->rt;
		$rw = $request->rw;
		$jenis_kelamin = $request->jenis_kelamin;
		$nomor_hp = $request->nomor_hp;
		$name = $request->name;
        $tempat_lahir = $request->tempat_lahir;
		$tanggal_lahir = ($request->tanggal_lahir) ? date('Y-m-d', strtotime($request->tanggal_lahir)) : NULL;
		$kebutuhan_khusus = NULL;
		if($request->kebutuhan_khusus){
			$kebutuhan_khusus = json_decode($request->kebutuhan_khusus);
			$kebutuhan_khusus = serialize($kebutuhan_khusus);
		}
		$user = User::create([
			'sekolah_id' => $request->sekolah_id,
			'name' => $name,
			'username' => $request->nik,
			'email' => $request->nik.'@disdik.sampangkab.go.id',
			'password' => Hash::make($request->password),
			'sandi' => $request->password,
			'jenis_kelamin' => $request->jenis_kelamin,
			'bentuk_pendidikan_id' => $request->bentuk_pendidikan_id,
			'wna' => $request->wna,
			'negara_id' => $request->negara_id,
			'provinsi_id' => $provinsi_id,
			'kabupaten_id' => $kabupaten_id,
			'kecamatan_id' => $kecamatan_id,
			'desa_id' => $desa_id,
			'provinsi' => $nama_provinsi,
			'kabupaten' => $nama_kabupaten,
			'kecamatan' => $nama_kecamatan,
			'desa' => $nama_desa,
			'nomor_hp' => $request->nomor_hp,
			'alamat' => $request->alamat,
			'rt' => $request->rt,
			'rw' => $request->rw,
			'nama_ortu' => $request->nama_ortu,
			'kebutuhan_khusus' => $kebutuhan_khusus,
			'tempat_lahir' => $request->tempat_lahir,
			'tanggal_lahir' => $tanggal_lahir,
			'jenis_tinggal_id' => $request->jenis_tinggal_id,
			'agama_id' => $request->agama_id,
		]);
		if($user){
			$with = 'success';
			$text = 'Pendaftar berhasil disimpan.';
		} else {
			$with = 'error';
			$text = 'Pendaftar gagal disimpan. Periksa kembali isian Anda';
		}
		return response()->json(['status' => $with, 'message' => $text, 'data' => $user]);
	}
    public function update_profile(Request $request){
		$id = $request->user_id;
		$user = User::findOrFail($id);
		if($user->hasRole('siswa')){
			$messages = [
				'image.mimes'	=> 'Foto profile harus berekstensi jpg/png/jpeg',
				'image.image'	=> 'Foto profile harus berekstensi jpg/png/jpeg',
				'wna.required' => 'Warga Negara tidak boleh kosong',
				'negara_id.required' => 'Negara tidak boleh kosong',
				'provinsi_id.required' => 'Provinsi tidak boleh kosong',
				'kabupaten_id.required' => 'Kabupaten tidak boleh kosong',
				'kecamatan_id.required' => 'Kecamatan tidak boleh kosong',
				'desa_id.required' => 'Desa/Kelurahan tidak boleh kosong',
				'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
				'nomor_hp.required' => 'Nomor HP tidak boleh kosong',
				'name.required' => 'Nama Lengkap tidak boleh kosong',
				'alamat.required' => 'Alamat tidak boleh kosong',
				'rt.required' => 'RT tidak boleh kosong',
				'rw.required' => 'RW tidak boleh kosong',
				'tempat_lahir.required' => 'Tempat Lahir tidak boleh kosong',
				'tanggal_lahir.required' => 'Tanggal Lahir tidak boleh kosong',
				'agama_id.required' => 'Agama tidak boleh kosong',
			];
			$validator = Validator::make(request()->all(), [
				'image'					=> 'nullable|image|mimes:jpg,png,jpeg',
				'name'					=> 'required',
				'wna'					=> 'required',
				'negara_id'				=> 'required',
				'provinsi_id'			=> 'required',
				'kabupaten_id'			=> 'required',
				'agama_id'				=> 'required',
				'kecamatan_id'			=> 'required',
				'desa_id'				=> 'required',
				'nomor_hp'				=> 'required',
				'jenis_kelamin'			=> 'required',
				'alamat'				=> 'required',
				'rt'					=> 'required',
				'rw'					=> 'required',
				'tempat_lahir'			=> 'required',
				'tanggal_lahir'			=> 'required',
				'email'					=> 'required|email|unique:users,email,' . $id .',user_id',
			],
			$messages
			)->validate();
		} else {
			$messages = [
				'image.mimes'	=> 'Foto profile harus berekstensi jpg/png/jpeg',
				'image.image'	=> 'Foto profile harus berekstensi jpg/png/jpeg',
				'name.required' => 'Nama Lengkap tidak boleh kosong',
			];
			$validator = Validator::make(request()->all(), [
				'image'					=> 'nullable|image|mimes:jpg,png,jpeg',
				'name'					=> 'required',
				'email'					=> 'required|email|unique:users,email,' . $id .',user_id',
			],
			$messages
			)->validate();
		}
		//JIKA FOLDERNYA BELUM ADA
        if (!File::isDirectory($this->path)) {
            //MAKA FOLDER TERSEBUT AKAN DIBUAT
            File::makeDirectory($this->path, 0777, true, true);
		}
		$path = public_path('images');
		//MENGAMBIL FILE IMAGE DARI FORM
        $file = $request->file('image');
		//$current_password_post = $request->current_password;
		if($file){
			$image_path = public_path("images/".$user->photo);
			if(File::exists($image_path)) {
				File::delete($image_path);
			}
			//MEMBUAT NAME FILE DARI GABUNGAN TIMESTAMP DAN UNIQID()
			$fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
			//UPLOAD ORIGINAN FILE (BELUM DIUBAH DIMENSINYA)
			Image::make($file)->save($this->path . '/' . $fileName);
			
			//LOOPING ARRAY DIMENSI YANG DI-INGINKAN
			//YANG TELAH DIDEFINISIKAN PADA CONSTRUCTOR
			foreach ($this->dimensions as $row) {
				$image_dimensions = public_path("images/".$row.'/'.$user->photo);
				if(File::exists($image_dimensions)) {
					File::delete($image_dimensions);
				}
				//MEMBUAT CANVAS IMAGE SEBESAR DIMENSI YANG ADA DI DALAM ARRAY 
				$canvas = Image::canvas($row, $row);
				//RESIZE IMAGE SESUAI DIMENSI YANG ADA DIDALAM ARRAY 
				//DENGAN MEMPERTAHANKAN RATIO
				$resizeImage  = Image::make($file)->resize($row, $row, function($constraint) {
					$constraint->aspectRatio();
				});
				
				//CEK JIKA FOLDERNYA BELUM ADA
				//if (!File::isDirectory($this->path . '/' . $row)) {
					//MAKA BUAT FOLDER DENGAN NAMA DIMENSI
					//File::makeDirectory($this->path . '/' . $row);
				//}
				$row_path = public_path('images/'.$row);
				if(!File::isDirectory($row_path)){
					File::makeDirectory($row_path, 0777, true, true);
				}
				//MEMASUKAN IMAGE YANG TELAH DIRESIZE KE DALAM CANVAS
				$canvas->insert($resizeImage, 'center');
				//SIMPAN IMAGE KE DALAM MASING-MASING FOLDER (DIMENSI)
				$canvas->save($this->path . '/' . $row . '/' . $fileName);
			}
			$user->photo = $fileName;
		}
		$provinsi = Wilayah::find($request->provinsi_id);
		if($provinsi){
			$user->provinsi_id = $request->provinsi_id;
			$user->provinsi = $provinsi->nama;
		} else {
			$user->provinsi_id = NULL;
			$user->provinsi = $request->provinsi_id;
		}
		$kabupaten = Wilayah::find($request->kabupaten_id);
		if($kabupaten){
			$user->kabupaten_id = $request->kabupaten_id;
			$user->kabupaten = $kabupaten->nama;
		} else {
			$user->kabupaten_id = NULL;
			$user->kabupaten = $request->kabupaten_id;
		}
		$kecamatan = Wilayah::find($request->kecamatan_id);
		if($kecamatan){
			$user->kecamatan_id = $request->kecamatan_id;
			$user->kecamatan = $kecamatan->nama;
		} else {
			$user->kecamatan_id = NULL;
			$user->kecamatan = $request->kecamatan_id;
		}
		$desa = Wilayah::find($request->desa_id);
		if($desa){
			$user->desa_id = $request->desa_id;
			$user->desa = $desa->nama;
		} else {
			$user->desa_id = NULL;
			$user->desa = $request->desa_id;
		}
		$user->nama_ortu = $request->nama_ortu;
		$user->wna = $request->wna;
		$user->negara_id = $request->negara_id;
		$user->agama_id = $request->agama_id;
		$user->jenis_tinggal_id = $request->jenis_tinggal_id;
		$user->alamat = $request->alamat;
		$user->rt = $request->rt;
		$user->rw = $request->rw;
		$user->jenis_kelamin = $request->jenis_kelamin;
		$user->nomor_hp = $request->nomor_hp;
		$user->name = $request->input('name');
        $user->email = strtolower($request->input('email'));
		$user->tempat_lahir = $request->tempat_lahir;
		$user->tanggal_lahir = ($request->tanggal_lahir) ? date('Y-m-d', strtotime($request->tanggal_lahir)) : NULL;
		if($request->kebutuhan_khusus){
			$kebutuhan_khusus = json_decode($request->kebutuhan_khusus);
			$user->kebutuhan_khusus = serialize($kebutuhan_khusus);
		}
		if($user->save()){
			$with = 'success';
			$text = 'Profile pengguna berhasil diperbaharui.';
		} else {
			$with = 'error';
			$text = 'Profile pengguna gagal diperbaharui. Periksa kembali isian Anda';
		}
		return response()->json(['status' => 'success', 'message' => 'Profile pengguna berhasil diperbaharui', 'data' => $user]);
	}
	public function reset_passsword(Request $request){
		$user = User::find($request->user_id);
		$user->sandi = $user->username;
		$user->password = Hash::make($user->username);
		if($user->save()){
			$response = [
				'title' => 'Berhasil',
				'text' => 'Password pengguna berhasil direset',
				'icon' => 'success',
			];
		} else {
			$response = [
				'title' => 'Gagal',
				'text' => 'Password pengguna gagal direset',
				'icon' => 'error',
			];
		}
		return response()->json($response);
	}
	public function destroy($id){
		$user = User::withCount('sekolah_sasaran')->find($id);
		if($user->sekolah_sasaran_count){
			$response = [
				'title' => 'Gagal',
				'text' => 'Verifikator masih memiliki sekolah sasaran. Silahkan ganti verifikator terlebih dahulu',
				'icon' => 'error',
			];
		} else {
			$user->delete();
			$response = [
				'title' => 'Berhasil',
				'text' => 'Verifikator berhasil dihapus',
				'icon' => 'success',
			];
		}
		return response()->json($response);
	}
	public function update(Request $request, $id){
		$messages = [
			'name.required'	=> 'Nama Lengkap tidak boleh kosong',
			'email.required'	=> 'Email tidak boleh kosong',
			//'token.required' => 'Token tidak boleh kosong',
			//'token.unique' => 'Token sudah terdaftar di database',
		];
		$validator = Validator::make(request()->all(), [
			'name'					=> 'required',
			//'token'					=> 'required|unique:users,token,' . $id .',user_id',
            'email'					=> 'required|email|unique:users,email,' . $id .',user_id',
		],
		$messages
		)->validate();
		$user = User::find($id);
		$user->name = $request->name;
		//$user->nomor_hp = $request->nomor_hp;
		$user->email = $request->email;
		//$user->token = strtolower($request->token);
		//$user->nip = $request->nip;
		if($request->password){
			$user->password = Hash::make($request->password);
		}
		if($user->save()){
			$response = [
				'title' => 'Berhasil',
				'text' => 'Data Operator Sekolah berhasil diperbaharui',
				'icon' => 'success',
			];
		} else {
			$response = [
				'title' => 'Gagal',
				'text' => 'Data Operator Sekolah gagal diperbaharui',
				'icon' => 'error',
			];
		}
		return response()->json(['status' => 'success', 'data' => $user, 'status' => $response]);
	}
	public function get_simpan_koordinat(Request $request){
		$user = User::find($request->user_id);
        $user->bujur = $request->bujur;
        $user->lintang = $request->lintang;
        $user->save();
        return response()->json(['status' => 'success', 'data' => 'koordinat']);
	}
	public function get_mata_pelajaran(Request $request){
		$all_data = Mata_pelajaran::get();
		$nilai = Nilai::where('user_id', $request->user_id)->get();
        $all_nilai = [];
        foreach($nilai as $n){
            //$all_nilai[$n->mata_pelajaran_id][$n->kelas][$n->semester] = $n->nilai;
			$all_nilai[$n->mata_pelajaran_id] = $n->nilai;
        }
        return response()->json(['status' => 'success', 'data' => $all_data, 'nilai' => $all_nilai]);
	}
	public function get_simpan_nilai(Request $request){
		$nilai_rapor = $request->nilai;
		foreach($nilai_rapor as $mata_pelajaran_id => $nilai){
			Nilai::updateOrCreate(
				[
					'mata_pelajaran_id' => $mata_pelajaran_id,
					'user_id' => $request->user_id,
				],
				[
					'nilai' => $nilai,
				]
			);
		}
		return response()->json(['status' => 'success', 'message' => 'Nilai berhasil disimpan', 'data' => $nilai_rapor]);
	}
	public function get_simpan_nilai_old(Request $request){
		$nilai_rapor = ((array) json_decode($request->nilai)) ? HelperModel::objToArray(json_decode($request->nilai, true)) : NULL;
		if($nilai_rapor){
            foreach($nilai_rapor as $mata_pelajaran_id => $a){
                foreach($a as $kelas => $b){
                    foreach($b as $semester => $nilai){
                        Nilai::updateOrCreate(
                            [
                                'mata_pelajaran_id' => $mata_pelajaran_id,
                                'kelas' => $kelas,
                                'semester' => $semester,
                                'user_id' => $request->user_id,
                            ],
                            [
                                'nilai' => ($nilai) ? $nilai : 0,
                            ]
                        );
                    }
                }
            }
			return response()->json(['status' => 'success', 'message' => 'Nilai berhasil disimpan', 'data' => $nilai_rapor]);
        } else {
			return response()->json(['status' => 'error', 'message' => 'Nilai gagal disimpan']);
		}
		$messages = [
			'nilai.*.required'	=> 'Nilai tidak boleh kosong',
			'nilai.*.integer'	=> 'Nilai harus berupa angka',
		];
		$validator = Validator::make($request->all(), [
            'nilai.*' => 'required|integer',
        ],
		$messages
		)->validate();
		foreach($request->nilai as $key => $value){
			Nilai::updateOrCreate(
				[
					'user_id' => $request->user_id,
					'mata_pelajaran_id' => $key,
				],
				[
					'nilai' => $value,
				]
			);
		}
        return response()->json(['status' => 'success', 'data' => 'koordinat']);
	}
	public function get_simpan_ijazah(Request $request){
		$messages = [
			'ijazah.mimes'	=> 'File Bukti Kelulusan/Ijazah harus berekstensi jpg/png/jpeg/pdf',
			'ijazah.required'	=> 'File Bukti Kelulusan/Ijazah tidak boleh kosong',
			//'nilai.*.required'	=> 'Nilai tidak boleh kosong',
			//'nilai.*.integer'	=> 'Nilai harus berupa angka',
		];
		$validator = Validator::make($request->all(), [
            //'nilai.*' => 'required|integer',
			'ijazah'	=> 'required|mimes:jpg,png,jpeg,pdf',
        ],
		$messages
		)->validate();
		$file = $request->file('ijazah');
        $fileIjazah = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move('uploads', $fileIjazah);
		$user = User::find($request->user_id);
		$user->ijazah = $fileIjazah;
		$user->save();
		return response()->json(['status' => 'success', 'data' => 'koordinat']);
	}
	public function delete_data(Request $request){
		if($request->route('query') == 'skhu'){
			$user_id = $request->route('id');
			$user = User::find($user_id);
			$user->skhu = NULL;
			$user->save();
			File::delete('uploads/'.$user->skhu);
			Nilai::where('user_id', $user_id)->delete();
			return response()->json(['title' => 'Berhasil', 'status' => 'success', 'message' => 'File SKHU berhasil dihapus', 'user_id' => $user_id]);
		} elseif($request->route('query') == 'piagam'){
			$id = $request->route('id');
			$piagam = Piagam::find($id);
			File::delete('uploads/'.$piagam->dokumen);
			$piagam->delete();
			return response()->json(['title' => 'Berhasil', 'status' => 'success', 'message' => 'Data Piagam Kejuaraan berhasil dihapus']);
		} elseif($request->route('query') == 'user'){
			$id = $request->route('id');
			$user = User::find($id);
			$user->delete();
			return response()->json(['title' => 'Berhasil', 'status' => 'success', 'message' => 'Data Pengguna berhasil dihapus']);
		}
        return response()->json(['title' => 'Gagal', 'status' => 'error', 'message' => 'Tidak ada data terhapus']);
	}
	public function get_simpan_prestasi(Request $request){
		$files = $request->file('upload_piagam');
		foreach($files as $key => $file){
			$filePiagam = 'piagam-'.Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
			$file->move('uploads', $filePiagam);
			Piagam::updateOrCreate(
				[
					'user_id' => $request->user_id,
					'tingkat_prestasi_id' => $request->prestasi_id[$key],
					'juara' => $request->juara[$key],
					'nama_lomba' => $request->nama_lomba[$key],
					'penyelenggara' => $request->penyelenggara[$key],
				],
				[
					'dokumen' => $filePiagam,
				]
			);
		}
		$data = Piagam::with(['tingkat_prestasi'])->where('user_id', $request->user_id)->get();
		return response()->json(['status' => 'success', 'data' => $data]);
	}
	public function get_simpan_operator(Request $request){
		$messages = [
			'name.required'	=> 'Nama Lengkap tidak boleh kosong',
			'email.email'	=> 'Email Tidak Valid',
			'email.unique'	=> 'Email sudah terdaftar di database',
			/*'current_password.nullable' => 'Please enter current password',
    		'password.nullable' => 'Please enter password',
			'email.required'	=> 'Email tidak boleh kosong',
			'password.required_with_all' => 'Kata sandi baru tidak boleh kosong',
			'password_confirmation.same' => 'Konfirmasi sandi tidak sama dengan sandi baru',*/
			'password.required' => 'Password tidak boleh kosong',
			'password.min' => 'Password minimal 3 karakter',
		];
		Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3'],
        ], $messages)->validate();

        $user = User::create([
			'sekolah_id' => $request->sekolah_id,
            'name' => $request->name,
			'username' => strtolower(str_replace(' ', '_', $request->name)),
            'email' => $request->email,
            'password' => Hash::make($request->password),
			'bentuk_pendidikan_id' => $request->jenjang,
        ]);
		if(!$user->hasRole('sekolah')){
			$role = Role::where('name', 'sekolah')->first();
			$user->attachRole($role);
		}
		$status = [
			'title' => 'Berhasil',
			'message' => 'Data operator berhasil disimpan',
			'status' => 'success',
		];
		return response()->json(['status' => 'success', 'data' => $user, 'status' => $status]);
	}
	public function get_cek_email(Request $request){
		if($request->id){
			$user = User::where('email', $request->email)->where('user_id', '<>', $request->id)->first();
		} else {
			$user = User::where('email', $request->email)->first();
		}
		return response()->json(['status' => 'success', 'data' => $user]);
	}
	public function get_check_nik(Request $request){
		$user = User::where('username', $request->nik)->first();
		return response()->json(['user' => $user]);
	}
}
