<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Dana;

class RiwayatDonasi extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        return view('livewire.riwayat-donasi', ['riwayat' => Dana::where('user_id', auth()->user()->id)->paginate(10)]);
    }
}
