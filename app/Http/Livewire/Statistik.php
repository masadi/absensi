<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class Statistik extends Component
{
    public $hari_ini;
    public function render()
    {
        $today = Carbon::parse('2022-07-11');
        $this->hari_ini = collect([
            $today->translatedFormat('l'),
            $today->add(1, 'day')->translatedFormat('l'),
            $today->add(1, 'day')->translatedFormat('l'),
            $today->add(1, 'day')->translatedFormat('l'),
            $today->add(1, 'day')->translatedFormat('l'),
            $today->add(1, 'day')->translatedFormat('l'),
            $today->add(1, 'day')->translatedFormat('l'),
        ]);
        return view('livewire.statistik');
    }
}
