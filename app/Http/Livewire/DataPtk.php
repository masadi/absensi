<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Ptk;
use App\Models\Sekolah;

class DataPtk extends Component
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
        return view('livewire.data-ptk', [
            'data_sekolah' => Sekolah::select('sekolah_id', 'nama')->get(),
            'collection' => Ptk::with(['sekolah' => function($query){
                $query->select('sekolah_id', 'nama');
            }])->orderBy($this->sortby, $this->sortbydesc)
                ->when($this->search, function($ptk) {
                    $ptk->where('nama', 'ILIKE', '%' . $this->search . '%')
                    ->orWhere('nuptk', 'ILIKE', '%' . $this->search . '%');
            })->when($this->sekolah_id, function($query) {
                $query->where('sekolah_id', $this->sekolah_id);
            })->paginate($this->per_page)
        ]);
    }
}
