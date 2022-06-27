<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DashboardDpw extends Component
{
    public function render()
    {
        return view('livewire.dashboard-dpw', [
            'user' => auth()->user(),
        ]);
    }
}
