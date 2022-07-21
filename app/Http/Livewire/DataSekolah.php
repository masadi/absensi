<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sekolah;
use App\Models\Ptk;
use App\Models\Peserta_didik;
use App\Models\User;
use App\Models\Role;
use App\Models\Team;
use App\Models\Semester;
use App\Models\Rombongan_belajar;
use App\Models\Anggota_rombel;

class DataSekolah extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function loadPerPage(){
        $this->resetPage();
    }
    public $sortby = 'created_at';
    public $sortbydesc = 'DESC';
    public $per_page = 10;
    public $npsn;
    public $sekolah_id;
    public $sekolah;

    public function render()
    {
        return view('livewire.data-sekolah', [
            'data_sekolah' => Sekolah::withCount(['ptk', 'pd' => function($query){
                $query->whereHas('anggota_rombel', function($query){
                    $query->where('semester_id', session('semester_aktif'));
                });
            }])->orderBy($this->sortby, $this->sortbydesc)
                ->when($this->search, function($ptk) {
                    $ptk->where('nama', 'ILIKE', '%' . $this->search . '%')
                    ->orWhere('npsn', 'ILIKE', '%' . $this->search . '%');
            })->paginate($this->per_page)
        ]);
    }
    public function store(){
        $sync_sekolah = Http::get('http://103.40.55.242/erapor_server/sync/get_sekolah/'.$this->npsn);
        $sekolah = json_decode($sync_sekolah->body());
        if(isset($sekolah->data[0])){
            $sekolah = $sekolah->data[0];
            $sekolah_id = strtolower($sekolah->sekolah_id);
            $new_sekolah = Sekolah::updateOrCreate(
                ['sekolah_id' => $sekolah_id],
                [
                    'npsn' => $sekolah->npsn,
                    'nama' => $sekolah->nama,
                    'nss' => $sekolah->nss,
                    'alamat' => $sekolah->alamat_jalan,
                    'desa_kelurahan' => $sekolah->desa_kelurahan,
                    'kode_pos' => $sekolah->kode_pos,
                    'lintang' => $sekolah->lintang,
                    'bujur' => $sekolah->bujur,
                    'no_telp' => $sekolah->nomor_telepon,
                    'no_fax' => $sekolah->nomor_fax,
                    'email' => $sekolah->username,
                    'website' => $sekolah->website,
                    'status_sekolah' => $sekolah->status_sekolah,
                ]
            );
            $this->toastr('success', 'Berhasil', 'Data Sekolah berhasil disimpan');
        } else {
            $this->toastr('error', 'Data Sekolah gagal disimpan', 'Periksa kembali NPSN yang dimasukkan');
        }
    }
    public function toastr($type, $title, $message){
        $this->dispatchBrowserEvent('toastr', ['type' => $type,  'title' => $title, 'message' => $message]);
    }
    public function syncPtk($sekolah_id){
        $this->sekolah_id = $sekolah_id;
        $this->sekolah = Sekolah::find($sekolah_id);;
        $this->ambil_ptk();
    }
    public function syncPd($sekolah_id){
        $this->sekolah_id = $sekolah_id;
        $this->sekolah = Sekolah::find($sekolah_id);;
        $this->ambil_pd();
    }
    public function ambil_ptk(){
        $response = Http::withHeaders([
            'x-api-key' => $this->sekolah_id,
        ])->withBasicAuth('admin', '1234')->asForm()->post('http://103.40.55.242/erapor_server/api/ptk', [
            'username_dapo'		=> $this->sekolah->email,
            'tahun_ajaran_id'	=> substr(session('semester_aktif'),0,4),
            'semester_id'		=> session('semester_aktif'),
            'sekolah_id'		=> $this->sekolah_id,
            'npsn'				=> $this->sekolah->npsn,
        ]);
        if($response->successful()){
            $all_data = $response->object();
            $role = Role::where('name', 'ptk')->first();
            $team = $this->get_team();
            if($all_data->dapodik){
                foreach($all_data->dapodik as $dapodik){
                    $email = ($dapodik->email) ?? $this->generateEmail();
                    $user = User::updateOrCreate(
                        [
                            'email' => $email,
                        ],
                        [
                        'sekolah_id' => $this->sekolah_id,
                        'name' => strtoupper($dapodik->nama),
                        'password' => bcrypt('12345678'),
                        ]
                    );
                    if(!$user->hasRole($role, $team)){
                        $user->attachRole($role, $team);
                    }
                    $ptk = Ptk::updateOrCreate(
                        ['ptk_id' => strtolower($dapodik->ptk_id)],
                        [
                        'sekolah_id' => $this->sekolah_id,
                        'user_id' => $user->id,
                        'nama' => strtoupper($dapodik->nama),
                        'nuptk' => ($dapodik->nuptk) ? $dapodik->nuptk : 123,
                        'jenis_kelamin' => $dapodik->jenis_kelamin,
                        'tempat_lahir' => $dapodik->tempat_lahir,
                        'tanggal_lahir' => $dapodik->tanggal_lahir,
                        'jenis_ptk_id' => $dapodik->jenis_ptk_id,
                        'agama_id' => $dapodik->agama_id,
                        'status_kepegawaian_id' => $dapodik->status_kepegawaian_id,
                        'email' => $email,
                        ]
                    );
                    $this->toastr('success', 'Sukses', $user->name.' berhasil disimpan');
                }
            } else {
                $this->toastr('error', 'Sinkronisasi PTK gagal', 'Pastikan Dapodik Anda sudah di sinkronisasi!');
            }
        } else {
            $this->toastr('error', 'Gagal', 'Sinkronisasi PTK gagal. Silahkan coba beberapa saat lagi');
        }
    }
    public function ambil_pd(){
        $response = Http::withHeaders([
            'x-api-key' => $this->sekolah_id,
        ])->withBasicAuth('admin', '1234')->asForm()->post('http://103.40.55.242/erapor_server/api/peserta_didik_aktif', [
            'username_dapo'		=> $this->sekolah->email,
            'tahun_ajaran_id'	=> substr(session('semester_aktif'),0,4),
            'semester_id'		=> session('semester_aktif'),
            'sekolah_id'		=> $this->sekolah_id,
            'npsn'				=> $this->sekolah->npsn,
        ]);
        if($response->successful()){
            $all_data = $response->object();
            $role = Role::where('name', 'pd')->first();
            $team = $this->get_team();
            if($all_data->dapodik){
                foreach($all_data->dapodik as $dapodik){
                    $email = ($dapodik->email) ?? $this->generateEmail();
                    $user = User::updateOrCreate(
                        [
                            'email' => $email,
                        ],
                        [
                        'sekolah_id' => $this->sekolah_id,
                        'name' => strtoupper($dapodik->nama),
                        'password' => bcrypt('12345678'),
                        ]
                    );
                    if(!$user->hasRole($role, $team)){
                        $user->attachRole($role, $team);
                    }
                    $peserta_didik = Peserta_didik::updateOrCreate(
                        ['peserta_didik_id' => strtolower($dapodik->peserta_didik_id)],
                        [
                        'sekolah_id' => $this->sekolah_id,
                        'user_id' => $user->id,
                        'nama' => strtoupper($dapodik->nama),
                        'no_induk' => ($dapodik->nipd) ? $dapodik->nipd : 123,
                        'nisn' => $dapodik->nisn,
                        'nik' => $dapodik->nik,
                        'jenis_kelamin' => $dapodik->jenis_kelamin,
                        'tempat_lahir' => $dapodik->tempat_lahir,
                        'tanggal_lahir' => $dapodik->tanggal_lahir,
                        'agama_id' => $dapodik->agama_id,
                        'alamat' => $dapodik->alamat_jalan,
                        'desa_kelurahan' => $dapodik->desa_kelurahan,
                        'kecamatan' => $dapodik->kecamatan,
                        'kode_wilayah' => $dapodik->kode_wilayah,
                        'nama_ayah' => $dapodik->nama_ayah,
                        'nama_ibu' => $dapodik->nama_ibu_kandung,
                        'email' => $email,
                        ]
                    );
                    Rombongan_belajar::updateOrCreate(
                        [
                            'rombongan_belajar_id' => $dapodik->rombongan_belajar_id,
                        ],
                        [
                            'nama' => $dapodik->nama_rombongan_belajar,
                            'semester_id' => session('semester_aktif'),
                            'sekolah_id' => $this->sekolah_id,
                            'tingkat_pendidikan_id' => $dapodik->tingkat_pendidikan_id,
                            'ptk_id' => $dapodik->ptk_id,
                        ]
                    );
                    Anggota_rombel::updateOrCreate(
                        [
                            'anggota_rombel_id' => $dapodik->anggota_rombel_id,
                        ],
                        [
                            'rombongan_belajar_id' => $dapodik->rombongan_belajar_id,
                            'peserta_didik_id' => $dapodik->peserta_didik_id,
                            'semester_id' => session('semester_aktif'),
                        ]
                    );
                    $this->toastr('success', 'Sukses', $user->name.' berhasil disimpan');
                }
            } else {
                $this->toastr('error', 'Sinkronisasi PD gagal', 'Pastikan Dapodik Anda sudah di sinkronisasi!');
            }
        } else {
            $this->toastr('error', 'Gagal', 'Sinkronisasi PD gagal. Silahkan coba beberapa saat lagi');
        }
    }
    public function get_team(){
        $semester = Semester::find(session('semester_aktif'));
        $team = Team::where('name', $semester->nama)->first();
        return $team;
    }
    private function generateEmail(){
        $random = Str::random(6);
        return strtolower($random).'@ariyametta.sch.id';
    }
}
