<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Kategori;
use App\Models\Sekolah;
use App\Models\Ptk;
use App\Models\Kategori_ptk;
use App\Models\Kategori_hari;
use Carbon\Carbon;

class DataKategori extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $sortby = 'created_at';
    public $sortbydesc = 'DESC';
    public $per_page = 10;
    
    public $kategori_id;
    public $sekolah_id; 
    public $nama;
    public $is_libur;
    public $tanggal_mulai; 
    public $tanggal_akhir;
    public $sekolah;
    public $isLibur;
    public $data_ptk = [];
    public $nama_hari = ["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"];
    public $hari_selected;
    public $ptk_selected;
    public function getPtk($sekolah_id){
        if($sekolah_id){
            $this->data_ptk = Ptk::where('sekolah_id', $sekolah_id)->get();
        }
    }
    public function isLibur($value){
        $this->isLibur = $value;
    }
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
        'ptk_selected.*.ptk_id' => 'nullable',
        'hari_selected.*.nama' => 'nullable'
    ];
    protected $messages = [
        'nama.required' => 'Nama Kategori tidak boleh kosong!!',        
    ];
    public function save(){
        $kategori = Kategori::create([
            'sekolah_id' => ($this->sekolah_id) ? $this->sekolah_id : NULL,
            'nama' => $this->nama,
            'is_libur' => ($this->is_libur) ?? 0,
            'tanggal_mulai' => ($this->tanggal_mulai) ? date('Y-m-d', strtotime($this->tanggal_mulai)) : NULL,
            'tanggal_akhir' => ($this->tanggal_akhir) ? date('Y-m-d', strtotime($this->tanggal_akhir)) : NULL,
        ]);
        if($this->ptk_selected){
            foreach($this->ptk_selected as $ptk_id){
                Kategori_ptk::create([
                    'ptk_id' => $ptk_id['ptk_id'],
                    'kategori_id' => $kategori->id,
                ]);
            }
        }
        if($this->hari_selected){
            foreach($this->hari_selected as $hari){
                Kategori_hari::create([
                    'nama' => $hari['nama'],
                    'kategori_id' => $kategori->id,
                ]);
            }
        }
        $this->close();
        $this->alert('info', 'Data kategori berhasil disimpan', [
            'position' => 'center'
        ]);
    }
    public function update(){
        $this->setData('update');
        $this->close();
        $this->alert('info', 'Data kategori berhasil diperbaharui', [
            'position' => 'center'
        ]);
    }
    public function delete(){
        $this->setData('delete');
        $this->close();
        $this->alert('info', 'Data kategori berhasil dihapus', [
            'position' => 'center'
        ]);
    }
    public function close()
    {
        /*
        public $kategori_id;
        public $sekolah_id; 
        public $nama;
        public $is_libur;
        public $tanggal_mulai; 
        public $tanggal_akhir;
        public $sekolah;
        public $isLibur;
        public $data_ptk = [];
        public $nama_hari = ["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"];
        public $hari_selected = [];
        public $ptk_selected = [];
        */
        $this->reset(['kategori_id', 'sekolah_id', 'nama', 'nama', 'is_libur', 'tanggal_mulai', 'tanggal_akhir', 'sekolah', 'isLibur', 'data_ptk', 'nama_hari', 'hari_selected', 'ptk_selected']);
        $this->emit('close-modal');
        $this->resetPage();
    }
    protected $listeners = ['addModal', 'editModal', 'deleteModal', 'detilModal', 'resetData'];
    public function addModal(){
        $this->reset(['kategori_id', 'sekolah_id', 'nama', 'nama', 'is_libur', 'tanggal_mulai', 'tanggal_akhir', 'sekolah', 'isLibur', 'data_ptk', 'nama_hari', 'hari_selected', 'ptk_selected']);
    }
    public function editModal(){
        $this->setData('view');
        //dd($this->kategori_id);
    }
    public function deleteModal(){
        //dd($this->kategori_id);
    }
    public function detilModal(){
        $this->setData('view');
        //dd($this->kategori_id);
    }
    public function resetData(){
        $this->reset(['kategori_id', 'sekolah_id', 'nama', 'is_libur', 'tanggal_mulai', 'tanggal_akhir', 'sekolah', 'isLibur', 'data_ptk', 'nama_hari', 'hari_selected', 'ptk_selected']);
    }
    public function getID($id){
        $this->kategori_id = $id;
        //$this->setData('view');
    }
    /*public function updating($name, $value)
    {
        $this->{$name} = $value;
    }*/
    public function setData($action){
        $find = Kategori::find($this->kategori_id);
        if($action == 'update'){
            $find->sekolah_id = $this->sekolah_id;
            $find->nama = $this->nama;
            $find->is_libur = $this->is_libur;
            $find->tanggal_mulai = ($this->tanggal_mulai) ? date('Y-m-d', strtotime($this->tanggal_mulai)) : NULL;
            $find->tanggal_akhir = ($this->tanggal_akhir) ? date('Y-m-d', strtotime($this->tanggal_akhir)) : NULL;
            $find->save();
            if($this->ptk_selected){
                foreach($this->ptk_selected as $ptk_id){
                    if($ptk_id['ptk_id']){
                        Kategori_ptk::updateOrCreate([
                            'ptk_id' => $ptk_id['ptk_id'],
                            'kategori_id' => $find->id,
                        ]);
                    }
                }
                //dd($this->ptk_selected->filter());
                Kategori_ptk::where('kategori_id', $find->id)->whereNotIn('ptk_id', $this->ptk_selected)->delete();
            }
            if($this->hari_selected){
                foreach($this->hari_selected as $hari){
                    Kategori_hari::updateOrCreate([
                        'nama' => $hari['nama'],
                        'kategori_id' => $find->id,
                    ]);
                }
                Kategori_hari::where('kategori_id', $find->id)->whereNotIn('nama', $this->hari_selected)->delete();
            }
        } elseif($action == 'delete'){
            $find->delete();
        } else {
            //$this->reset(['sekolah', 'kategori_id', 'sekolah_id', 'nama', 'is_libur', 'tanggal_mulai', 'tanggal_akhir', 'hari_selected', 'ptk_selected']);
            $this->sekolah_id = $find->sekolah_id; 
            $this->nama = $find->nama; 
            $this->is_libur = $find->is_libur; 
            $this->tanggal_mulai = $find->tanggal_mulai; 
            $this->tanggal_akhir = $find->tanggal_akhir; 
            $this->sekolah = $find->sekolah;
            if($find->sekolah_id){
                $this->data_ptk = Ptk::where('sekolah_id', $find->sekolah_id)->get();
            }
            $this->hari_selected = ($find->hari->count()) ? $find->hari : [];
            $this->ptk_selected = ($find->ptk->count()) ? $find->ptk : [];
        }
    }
}
