<?php

namespace App\Http\Livewire\Mapping;

use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Kategori;
use App\Models\Jam;
use App\Models\Sekolah;
use App\Models\Ptk;
use App\Models\Kategori_ptk;
use App\Models\Kategori_hari;
use Carbon\Carbon;

class Index extends Component
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
    public $editMode = false;

    //jam
    public $scan_masuk_start_jam;
    public $scan_masuk_start_menit;
    public $scan_masuk_end_jam;
    public $scan_masuk_end_menit;
    public $waktu_akhir_masuk_jam;
    public $waktu_akhir_masuk_menit;
    public $scan_pulang_start_jam;
    public $scan_pulang_start_menit;
    public $scan_pulang_end_jam;
    public $scan_pulang_end_menit;
    public $kategori;
    //db
    public $scan_masuk_start;
    public $scan_masuk_end;
    public $waktu_akhir_masuk;
    public $scan_pulang_start;
    public $scan_pulang_end;
    public function render()
    {
        return view('livewire.mapping.index', [
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
    public function getPtk($sekolah_id){
        if($sekolah_id){
            $this->data_ptk = Ptk::where('sekolah_id', $sekolah_id)->get();
        } else {
            $this->data_ptk = [];
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
    protected $rules = [
        'nama' => 'required',
        'scan_masuk_start_jam' => 'required',
        'scan_masuk_end_jam' => 'required',
        'scan_pulang_start_jam' => 'required',
        'scan_pulang_end_jam' => 'required',
        'scan_masuk_start_menit' => 'required',
        'scan_masuk_end_menit' => 'required',
        'scan_pulang_start_menit' => 'required',
        'scan_pulang_end_menit' => 'required',
        'waktu_akhir_masuk_jam' => 'required',
        'waktu_akhir_masuk_menit' => 'required',
        'ptk_selected.*.ptk_id' => 'nullable',
        'hari_selected.*.nama' => 'nullable'
    ];
    protected $messages = [
        'nama.required' => 'Nama Kategori tidak boleh kosong!!',
        'scan_masuk_start_jam.required' => 'Jam Mulai Scan Masuk tidak boleh kosong!!',
        'scan_masuk_start_menit.required' => 'Menit Mulai Scan Masuk tidak boleh kosong!',
        'scan_masuk_end_jam.required' => 'Jam Akhir Scan Masuk tidak boleh kosong!!',
        'scan_masuk_end_menit.required' => 'Menit Akhir Scan Masuk tidak boleh kosong!',
        'waktu_akhir_masuk_jam.required' => 'Jam Waktu Akhir Masuk tidak boleh kosong!!',
        'waktu_akhir_masuk_menit.required' => 'Menit Waktu Akhir Masuk tidak boleh kosong!',
        'scan_pulang_start_jam.required' => 'Jam Mulai Scan Pulang tidak boleh kosong!!',
        'scan_pulang_start_menit.required' => 'Menit Mulai Scan Pulang tidak boleh kosong!',
        'scan_pulang_end_jam.required' => 'Jam Akhir Scan Pulang tidak boleh kosong!',
        'scan_pulang_end_menit.required' => 'Menit Akhir Scan Pulang tidak boleh kosong!',
    ];
    public function store(){
        $this->validate();
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
        Jam::create([
            'kategori_id' => $kategori->id,
            'scan_masuk_start' => $this->scan_masuk_start_jam.':'.$this->scan_masuk_start_menit,
            'scan_masuk_end' => $this->scan_masuk_end_jam.':'.$this->scan_masuk_end_menit,
            'waktu_akhir_masuk' => $this->waktu_akhir_masuk_jam.':'.$this->waktu_akhir_masuk_menit,
            'scan_pulang_start' => $this->scan_pulang_start_jam.':'.$this->scan_pulang_start_menit,
            'scan_pulang_end' => $this->scan_pulang_end_jam.':'.$this->scan_pulang_end_menit,
        ]);
        $this->close();
        $this->alert('info', 'Data Jam berhasil disimpan', [
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
    private function resetInputFields(){
        $this->reset(['kategori_id', 'sekolah_id', 'nama', 'nama', 'is_libur', 'tanggal_mulai', 'tanggal_akhir', 'sekolah', 'isLibur', 'data_ptk', 'nama_hari', 'hari_selected', 'ptk_selected', 'scan_masuk_start_jam', 'scan_masuk_start_menit', 'scan_masuk_end_jam', 'scan_masuk_end_menit', 'waktu_akhir_masuk_jam', 'waktu_akhir_masuk_menit', 'scan_pulang_start_jam', 'scan_pulang_start_menit', 'scan_pulang_end_jam', 'scan_pulang_end_menit']);
    }
    public function cancel(){
        $this->resetInputFields();
    }
    public function close()
    {
        $this->reset(['kategori_id', 'sekolah_id', 'nama', 'nama', 'is_libur', 'tanggal_mulai', 'tanggal_akhir', 'sekolah', 'isLibur', 'data_ptk', 'nama_hari', 'hari_selected', 'ptk_selected']);
        $this->emit('close-modal');
        $this->resetPage();
    }
    protected $listeners = ['cancel', 'addModal', 'editModal', 'deleteModal', 'detilModal', 'resetData'];
    public function addModal(){
        $this->reset(['kategori_id', 'sekolah_id', 'nama', 'nama', 'is_libur', 'tanggal_mulai', 'tanggal_akhir', 'sekolah', 'isLibur', 'data_ptk', 'nama_hari', 'hari_selected', 'ptk_selected']);
    }
    public function editModal(){
        $this->editMode = TRUE;
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
        $this->setData('view');
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
            if($find->hari->count()){
                foreach($find->hari as $hari){
                    $result[] = $hari->nama;
                }
                $this->hari_selected = collect($result);
            } else {
                $this->hari_selected = collect([]);
            }
            //$this->hari_selected = ($find->hari->count()) ? $find->hari()->select('nama')->get() : [];
            //$this->ptk_selected = ($find->ptk->count()) ? $find->ptk()->select('ptk_id')->get() : [];
        }
    }
}
