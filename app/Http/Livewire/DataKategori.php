<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Kategori;
use App\Models\Sekolah;
use Carbon\Carbon;

class DataKategori extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $sortby = 'created_at';
    public $sortbydesc = 'DESC';
    public $per_page = 10;
    public $tombol_add = 1;

    public $sekolah_id; 
    public $nama;
    public $is_libur;
    public $tanggal_mulai; 
    public $tanggal_akhir;
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function loadPerPage(){
        $this->resetPage();
    }
    public function getStart($start)
    {
        $this->tanggal_mulai = Carbon::createFromTimeStamp(strtotime($start))->format('d-m-Y');
    }
    public function getEnd($end){
        $this->tanggal_akhir = Carbon::createFromTimeStamp(strtotime($end))->format('d-m-Y');
    }
    public function render()
    {
        return view('livewire.data-kategori', [
            'data_kategori' => Kategori::withCount('jam')->orderBy($this->sortby, $this->sortbydesc)
                ->when($this->search, function($data) {
                    $data->where('nama', 'ILIKE', '%' . $this->search . '%')
                    ->orWhereHas('sekolah', function($query){
                        $query->where('nama', 'ILIKE', '%' . $this->search . '%');
                    });
            })->paginate($this->per_page),
            'data_sekolah' => Sekolah::select('sekolah_id', 'nama')->get(),
        ]);
    }
    protected $rules = [
        'nama' => 'required',
    ];
    protected $messages = [
        'nama.required' => 'Nama Kategori tidak boleh kosong!!',
        
    ];
    public function save(){
        Kategori::create([
            'sekolah_id' => $this->sekolah_id,
            'nama' => $this->nama,
            'is_libur' => ($this->is_libur) ?? 0,
            'tanggal_mulai' => ($this->tanggal_mulai) ? date('Y-m-d', strtotime($this->tanggal_mulai)) : NULL,
            'tanggal_akhir' => ($this->tanggal_akhir) ? date('Y-m-d', strtotime($this->tanggal_akhir)) : NULL,
        ]);
        $this->close();
    }
    public function update(){
        $this->close();
    }
    public function close()
    {
        $this->reset(['sekolah_id', 'nama', 'is_libur', 'tanggal_mulai', 'tanggal_akhir']);
        $this->emit('close-modal');
        //$this->dispatchBrowserEvent('close-modal');
    }
}
