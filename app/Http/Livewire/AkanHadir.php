<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Kehadiran;

class AkanHadir extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $user = auth()->user();
        return view('livewire.akan-hadir', [
            'results' => Kehadiran::where(function($query) use ($user){
                $query->where('user_id', $user->id);
                $query->whereHas('kegiatan', function($query){
                    $query->where('waktu', '<=', date('Y-m-d', strtotime(now())));
                });
            })->orderBy('created_at', 'DESC')->paginate(10)
        ]);
    }
}
