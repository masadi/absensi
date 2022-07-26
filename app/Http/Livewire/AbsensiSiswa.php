<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Peserta_didik;
use App\Models\Absen;
use App\Models\Absen_masuk;
use App\Models\Absen_pulang;
use App\Models\Semester;
use Carbon\Carbon;
use Pusher\Pusher;

class AbsensiSiswa extends Component
{
    public $peserta_didik_id;
    public $disabled_masuk = 'disabled';
    public $disabled_pulang = 'disabled';
    public $welcome = FALSE;
    public $bye = FALSE;

    public function getListeners()
    {
        return [
            'scan',
        ];
    }
    public function render()
    {
        return view('livewire.absensi-siswa');
    }
    public function store(){

    }
    private function getSemester(){
        return Semester::where('periode_aktif', 1)->first();
    }
    public function updatedPesertaDidikId(){
        //$this->peserta_didik_id = '0024bd68-f235-48f4-885a-ea4619c16b3b';
        $peserta_didik_id = Str::isUuid($this->peserta_didik_id);
        //dd($stringLength);
        if($peserta_didik_id){
            $peserta_didik = Peserta_didik::with(['kelas' => function($query){
                $query->where('anggota_rombel.semester_id', 20212);
            }])->find($this->peserta_didik_id);
            $absen = Absen::where(function($query){
                $query->whereDate('created_at', Carbon::today());
                $query->where('peserta_didik_id', $this->peserta_didik_id);
                $query->where('semester_id', $this->getSemester()->semester_id);
            })->first();
            if($absen){
                $absen->updated_at = now();
                $absen->save();
            } else {
                $absen = Absen::create([
                    'peserta_didik_id' => $this->peserta_didik_id,
                    'semester_id' => $this->getSemester()->semester_id,
                ]);
            }
            $absen_masuk = Absen_masuk::where('absen_id', $absen->id)->first();
            if(!$absen_masuk){
                Absen_masuk::updateOrCreate([
                    'absen_id' => $absen->id,
                ]);
                $this->toastr('success', 'Absen Masuk berhasil disimpan', 'Selamat Datang '.$peserta_didik->nama);
                $this->welcome = TRUE;
                $this->bye = FALSE;
            } else {
                Absen_pulang::updateOrCreate([
                    'absen_id' => $absen->id,
                ]);
                $this->toastr('success', 'Absen Pulang berhasil disimpan', 'Selamat Jalan '.$peserta_didik->nama);
                $this->bye = TRUE;
                $this->welcome = FALSE;
            }
            $absen->peserta_didik = $peserta_didik;
            $this->notification($absen);
            $this->reset(['peserta_didik_id']);
        } else {
            $this->toastr('error', 'Absen Gagal', 'Data Peserta Didik tidak ditemukan!');
        }
    }
    public function notification($absen)
    {
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );
        $pusher = new Pusher(
            'bc531acdb4578535bf7a',
            '9cec3f1e5c2a5cca6cbf',
            1442785, 
            $options
        );
        $pusher->trigger('notify-channel', 'App\\Events\\Notify', $absen);
 
    }
    public function toastr($type, $title, $message){
        $this->dispatchBrowserEvent('toastr', ['type' => $type,  'title' => $title, 'message' => $message]);
    }
    public function scan($peserta_didik_id){
        $this->peserta_didik_id = $peserta_didik_id;
        $this->updatedPesertaDidikId();
    }
}
