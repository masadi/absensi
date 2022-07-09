<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Absen;
use App\Models\Absen_masuk;
use App\Models\Absen_pulang;
use Carbon\Carbon;

class Absensi extends Component
{
    /*
    $now = Carbon::now();
    $start = Carbon::createFromTimeString('22:00');
    $end = Carbon::createFromTimeString('08:00');
    */
    use LivewireAlert;
    public $jarak_pengguna;
    public $jarak_pengaturan;
    public $status = 0;
    public $data = '';
    public $masuk = '';
    public $pulang = '';
    public $now = '';
    public $scan_masuk_start = '';
    public $scan_masuk_end = '';
    public $scan_pulang_start = '';
    public $scan_pulang_end = '';
    public $disabled_masuk = 'disabled';
    public $disabled_pulang = 'disabled';
    public $aktifitas_masuk = 'Belum ada aktifitas';
    public $aktifitas_pulang = 'Belum ada aktifitas';
    public function getListeners()
    {
        return [
            'confirmed'
        ];
    }
    public function absen($data)
    {
        $this->data = $data;
        $this->alert('warning', 'Anda Yakin akan Absen '.ucfirst($data).'?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Ya',
            'showCancelButton' => true,
            'cancelButtonText' => 'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled',
            'allowOutsideClick' => false,
            'timer' => null
        ]);
    }
    public function confirmed()
    {
        $user = auth()->user();
        $absen = Absen::where(function($query) use ($user){
            $query->whereDate('created_at', Carbon::today());
            $query->where('ptk_id', $user->ptk->ptk_id);
            $query->where('semester_id', session('semester_aktif'));
        })->first();
        if(!$absen){
            $absen = Absen::updateOrCreate([
                'ptk_id' => $user->ptk->ptk_id,
                'semester_id' => session('semester_aktif'),
            ]);
        }
        if($this->data == 'masuk'){
            Absen_masuk::create([
                'absen_id' => $absen->id,
            ]);
        } else {
            Absen_pulang::create([
                'absen_id' => $absen->id,
            ]);
        }
        //$this->status = 'status '.$this->data.':'.session('semester_aktif');
        $this->alert('info', 'Absen '.ucfirst($this->data).' berhasil disimpan', [
            'position' => 'center'
        ]);
    }
    public function render()
    {
        $user = auth()->user();
        $this->masuk = Absen_masuk::whereHas('absen', function($query) use ($user){
            $query->where('ptk_id', $user->ptk->ptk_id);
            $query->whereDate('created_at', Carbon::today());
        })->first();
        /*Absen::where(function($query) use ($user){
            $query->where('ptk_id', $user->ptk->ptk_id);
            $query->whereDate('created_at', Carbon::today());
            $query->whereHas('jenis_absen', function($query){
                $query->where('slug', 'masuk');
            });
        })->first();*/
        $this->pulang = Absen_pulang::whereHas('absen', function($query) use ($user){
            $query->where('ptk_id', $user->ptk->ptk_id);
            $query->whereDate('created_at', Carbon::today());
        })->first();
        /*Absen::where(function($query) use ($user){
            $query->where('ptk_id', $user->ptk->ptk_id);
            $query->whereDate('created_at', Carbon::today());
            $query->whereHas('jenis_absen', function($query){
                $query->where('slug', 'pulang');
            });
        })->first();*/
        $this->now = Carbon::now();
        if(session('settings_'.$user->sekolah_id.'_scan_masuk_start')){
            $this->scan_masuk_start = Carbon::createFromTimeString(session('settings_'.$user->sekolah_id.'_scan_masuk_start'));
            $this->scan_masuk_end = Carbon::createFromTimeString(session('settings_'.$user->sekolah_id.'_scan_masuk_end'));
            $this->scan_pulang_start = Carbon::createFromTimeString(session('settings_'.$user->sekolah_id.'_scan_pulang_start'));
            $this->scan_pulang_end = Carbon::createFromTimeString(session('settings_'.$user->sekolah_id.'_scan_pulang_end'));
            //public $disabled_masuk = '';
            //public $disabled_pulang = '';
            //dd($this->masuk);
            if ($this->now->between($this->scan_masuk_start, $this->scan_masuk_end) && !$this->masuk) {
                $this->disabled_masuk = '';
            }
            if ($this->now->between($this->scan_pulang_start, $this->scan_pulang_end) && !$this->pulang) {
                $this->disabled_pulang = '';
            }
            if($this->masuk){
                $this->aktifitas_masuk = Carbon::createFromTimeStamp(strtotime($this->masuk->created_at))->format('H:i');
            }
            if($this->pulang){
                $this->aktifitas_pulang = Carbon::createFromTimeStamp(strtotime($this->pulang->created_at))->format('H:i');
            }
            if(session('jarak') > session('settings_'.$user->sekolah_id.'_jarak')){
                $this->disabled_masuk = 'disabled';
                $this->disabled_pulang = 'disabled';
                $this->status = 'Jarak Anda dengan sekolah lebih dari '.session('settings_'.$user->sekolah_id.'_jarak').' meter';
            }
        } else {
            $this->disabled_masuk = 'disabled';
            $this->disabled_pulang = 'disabled';
            $this->status = 'Aplikasi belum di atur oleh Administrator. Silahkan hubungi Administrator untuk mengatur aplikasi!';
        }
        $this->jarak_pengguna = session('jarak');
        $this->jarak_pengaturan = session('settings_'.$user->sekolah_id.'_jarak');
        return view('livewire.absensi');
    }
}
