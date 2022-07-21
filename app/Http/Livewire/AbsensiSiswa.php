<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Peserta_didik;

class AbsensiSiswa extends Component
{
    public $peserta_didik_id;
    public $disabled_masuk = 'disabled';
    public $disabled_pulang = 'disabled';
    
    public function render()
    {
        return view('livewire.absensi-siswa');
    }
    public function store(){

    }
    public function updatedPesertaDidikId(){
        //$this->peserta_didik_id = '0024bd68-f235-48f4-885a-ea4619c16b3b';
        $peserta_didik_id = Str::isUuid($this->peserta_didik_id);
        //dd($stringLength);
        if($peserta_didik_id){
            $peserta_didik = Peserta_didik::find($this->peserta_didik_id);
            if($peserta_didik){
                dd('proses');
            } else {
                dd('skip');
            }
        }
    }
}
