<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DashboardAlumni extends Component
{
    public function render()
    {
        return view('livewire.dashboard-alumni', [
            'user' => auth()->user(),
        ]);
    }
}
