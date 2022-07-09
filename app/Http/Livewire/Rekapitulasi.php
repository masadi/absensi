<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Absen;
use App\Models\Sekolah;
use Livewire\WithPagination;

class Rekapitulasi extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function loadPerPage(){
        $this->resetPage();
    }
    public $sekolah_id;
    public $sortby = 'created_at';
    public $sortbydesc = 'DESC';
    public $per_page = 10;
    public $start = '';
    public $end = '';
    public $periode = 'Bulan Ini';
    protected $listeners = ['getStart', 'getEnd'];
    public function filterSekolah(){
        $this->resetPage();
    }
    public function getStart($start)
    {
        $this->start = Carbon::createFromTimeStamp(strtotime($start))->format('d/m/Y');
        $this->resetPage();
    }
    public function getEnd($end){
        $this->end = Carbon::createFromTimeStamp(strtotime($end))->format('d/m/Y');
        $this->resetPage();
    }
    public function render()
    {
        $user = auth()->user();
        if($user->hasRole('administrator', session('semester_id'))){
            $data_sekolah = Sekolah::select('sekolah_id', 'nama')->get();
        } else {
            $data_sekolah = NULL;
        }
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
            if($this->sekolah_id){
                $query->whereHas('ptk', function($query){
                    $query->where('sekolah_id', $this->sekolah_id);
                });
            }
            if($endDate){
                $query->whereDate('created_at', '>=', $startDate);
                $query->whereDate('created_at', '<=', $endDate);
            } else {
                $query->whereMonth('created_at', date('m'));
            }
        })->with(['ptk', 'absen_masuk', 'absen_pulang'])->when($this->search, function($absen) {
            $absen->wherehas('ptk', function($query){
                $query->where('nama', 'ILIKE', '%' . $this->search . '%')
                ->orWhere('nuptk', 'ILIKE', '%' . $this->search . '%');
            });
        })->paginate($this->per_page);
        if($this->end){
            $this->periode = 'Tanggal '.$this->start.' s/d '.$this->end;
        }
        return view('livewire.rekapitulasi', [
            'data_absen' => $all_data,
            'data_sekolah' => $data_sekolah,
        ]);
    }
}
