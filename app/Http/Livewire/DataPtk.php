<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Ptk;

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
    public $sortby = 'created_at';
    public $sortbydesc = 'DESC';
    public $per_page = 10;
    public function render()
    {
        return view('livewire.data-ptk', [
            'data_ptk' => Ptk::orderBy($this->sortby, $this->sortbydesc)
                ->when($this->search, function($ptk) {
                    $ptk->where('nama', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('nuptk', 'LIKE', '%' . $this->search . '%');
            })->paginate($this->per_page)
        ]);
    }
}
