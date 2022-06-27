<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DashboardUser extends Component
{
    public function render()
    {
        return view('livewire.dashboard-user', [
            'user' => auth()->user(),
        ]);
    }
}
