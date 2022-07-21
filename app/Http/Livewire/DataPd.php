<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Peserta_didik;
use App\Models\Sekolah;

class DataPd extends Component
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
    public function filterSekolah(){
        $this->resetPage();
    }
    public $sortby = 'nama';
    public $sortbydesc = 'ASC';
    public $per_page = 10;
    public $sekolah_id;

    public function render()
    {
        return view('livewire.data-pd', [
            'data_sekolah' => Sekolah::select('sekolah_id', 'nama')->get(),
            'collection' => Peserta_didik::with([
                'kelas' => function($query){
                    $query->where('anggota_rombel.semester_id', session('semester_aktif'));
                },
                'sekolah' => function($query){
                    $query->select('sekolah_id', 'nama');
                }
            ])->orderBy($this->sortby, $this->sortbydesc)
                ->when($this->search, function($ptk) {
                    $ptk->where('nama', 'ILIKE', '%' . $this->search . '%')
                    ->orWhere('nisn', 'ILIKE', '%' . $this->search . '%');
            })->when($this->sekolah_id, function($query) {
                $query->where('sekolah_id', $this->sekolah_id);
            })->paginate($this->per_page)
        ]);
    }
}
