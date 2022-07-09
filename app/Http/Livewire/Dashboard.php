<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Sekolah;

class Dashboard extends Component
{
    public $lat = '';
    public $lng = '';
    public function render()
    {
        $sekolah = Sekolah::first();
        $this->lat = ($sekolah->lintang) ? $sekolah->lintang : config('laravel-maps.map_center.lat');
        $this->lng = ($sekolah->bujur) ? $sekolah->bujur : config('laravel-maps.map_center.lng');
        return view('livewire.dashboard');
    }
}
