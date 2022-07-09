<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Absen;

class Rekapitulasi extends Component
{
    public $start = '';
    public $end = '';
    public $data_absen = '';
    public $periode = 'Bulan Ini';
    protected $listeners = ['getStart', 'getEnd'];
    public function getStart($start)
    {
        $this->start = Carbon::createFromTimeStamp(strtotime($start))->format('d/m/Y');
    }
    public function getEnd($end){
        $this->end = Carbon::createFromTimeStamp(strtotime($end))->format('d/m/Y');
    }
    public function render()
    {
        $user = auth()->user();
        $startDate = ($this->start) ? Carbon::createFromFormat('d/m/Y', $this->start) : '';
        $endDate = ($this->end) ? Carbon::createFromFormat('d/m/Y', $this->end) : '';
        $all_data = Absen::where(function($query) use ($user, $startDate, $endDate){
            if($user->hasRole('ptk', session('semester_id'))){
                $query->where('ptk_id', $user->ptk->ptk_id);
            }
            //$query->whereDate('created_at', Carbon::today());
            //$query->whereBetween('created_at', [$startDate, $endDate]);
            //$query->where('created_at', '>=', $startDate);
            //$query->where('created_at', '<=', $endDate);
            if($endDate){
                $query->whereDate('created_at', '>=', $startDate);
                $query->whereDate('created_at', '<=', $endDate);
            } else {
                $query->whereMonth('created_at', date('m'));
            }
        })->with(['ptk', 'absen_masuk', 'absen_pulang'])->get();
        $this->data_absen = $all_data;
        if($this->end){
            $this->periode = 'Tanggal '.$this->start.' s/d '.$this->end;
        }
        return view('livewire.rekapitulasi');
    }
}
