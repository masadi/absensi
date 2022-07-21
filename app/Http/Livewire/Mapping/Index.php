<?php

namespace App\Http\Livewire\Mapping;

use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Jam;
use App\Models\Sekolah;
use App\Models\Ptk;
use App\Models\Jam_hari;
use App\Models\Jam_ptk;
use App\Models\Jam_pd;
use App\Models\Nama_hari;
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
    
    public $jam_id;
    public $jam;
    public $sekolah_id; 
    public $untuk;
    public $nama;
    public $is_libur;
    public $tanggal_mulai; 
    public $tanggal_akhir;
    public $sekolah;
    public $isLibur;
    public $data_ptk = [];
    public $hari_selected = [];
    public $ptk_selected = [];
    public $editMode = false;

    //jam
    public $scan_masuk_start_jam = '05';
    public $scan_masuk_start_menit = '00';
    public $scan_masuk_end_jam = '08';
    public $scan_masuk_end_menit = '00';
    public $waktu_akhir_masuk_jam = '06';
    public $waktu_akhir_masuk_menit = '45';
    public $scan_pulang_start_jam = '08';
    public $scan_pulang_start_menit = '00';
    public $scan_pulang_end_jam = '21';
    public $scan_pulang_end_menit = '00';
    //db
    public $scan_masuk_start;
    public $scan_masuk_end;
    public $waktu_akhir_masuk;
    public $scan_pulang_start;
    public $scan_pulang_end;

    //show
    public $jam_ptk;
    public $jam_hari;
    public function render()
    {
        return view('livewire.mapping.index', [
            'collection' => Jam::with(['sekolah' => function($query){
                $query->select('sekolah_id', 'nama');
            }])->orderBy($this->sortby, $this->sortbydesc)
                ->when($this->search, function($data) {
                    $data->where('nama', 'ILIKE', '%' . $this->search . '%')
                    ->orWhereHas('sekolah', function($query){
                        $query->where('nama', 'ILIKE', '%' . $this->search . '%');
                    });
            })->paginate($this->per_page),
            'data_sekolah' => Sekolah::select('sekolah_id', 'nama')->get(),
            'nama_hari' => Nama_hari::select('nama')->get(),
        ]);
    }
    public function isUntuk($untuk){
        if($untuk == 'pd'){
            $this->data_ptk = [];
        }
    }
    public function getPtk($sekolah_id){
        if($sekolah_id){
            $this->data_ptk = Ptk::where('sekolah_id', $sekolah_id)->select('ptk_id', 'nama')->get();
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
        'scan_masuk_start_jam' => 'required|date_format:H',
        'scan_masuk_end_jam' => 'required|date_format:H',
        'scan_pulang_start_jam' => 'required|date_format:H',
        'scan_pulang_end_jam' => 'required|date_format:H',
        'scan_masuk_start_menit' => 'required|date_format:i',
        'scan_masuk_end_menit' => 'required|date_format:i',
        'scan_pulang_start_menit' => 'required|date_format:i',
        'scan_pulang_end_menit' => 'required|date_format:i',
        'waktu_akhir_masuk_jam' => 'required|date_format:H',
        'waktu_akhir_masuk_menit' => 'required|date_format:i',
        //'ptk_selected.*.ptk_id' => 'nullable',
        //'hari_selected.*.nama' => 'nullable'
    ];
    protected $messages = [
        'nama.required' => 'Nama tidak boleh kosong!!',
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
        'scan_masuk_start_jam.date_format' => 'Jam Mulai Scan Masuk format salah!',
        'scan_masuk_start_menit.date_format' => 'Menit Mulai Scan Masuk format salah!',
        'scan_masuk_end_jam.date_format' => 'Jam Akhir Scan Masuk format salah!!',
        'scan_masuk_end_menit.date_format' => 'Menit Akhir Scan Masuk format salah!',
        'waktu_akhir_masuk_jam.date_format' => 'Jam Waktu Akhir Masuk format salah!!',
        'waktu_akhir_masuk_menit.date_format' => 'Menit Waktu Akhir Masuk format salah!',
        'scan_pulang_start_jam.date_format' => 'Jam Mulai Scan Pulang format salah!!',
        'scan_pulang_start_menit.date_format' => 'Menit Mulai Scan Pulang format salah!',
        'scan_pulang_end_jam.date_format' => 'Jam Akhir Scan Pulang format salah!',
        'scan_pulang_end_menit.date_format' => 'Menit Akhir Scan Pulang format salah!',
    ];
    public function store(){
        $this->validate();
        $jam = Jam::create([
            'sekolah_id' => ($this->sekolah_id) ? $this->sekolah_id : NULL,
            'untuk' => $this->untuk,
            'nama' => $this->nama,
            'is_libur' => ($this->is_libur) ?? 0,
            'tanggal_mulai' => ($this->tanggal_mulai) ? date('Y-m-d', strtotime($this->tanggal_mulai)) : NULL,
            'tanggal_akhir' => ($this->tanggal_akhir) ? date('Y-m-d', strtotime($this->tanggal_akhir)) : NULL,
            'scan_masuk_start' => $this->scan_masuk_start_jam.':'.$this->scan_masuk_start_menit,
            'scan_masuk_end' => $this->scan_masuk_end_jam.':'.$this->scan_masuk_end_menit,
            'waktu_akhir_masuk' => $this->waktu_akhir_masuk_jam.':'.$this->waktu_akhir_masuk_menit,
            'scan_pulang_start' => $this->scan_pulang_start_jam.':'.$this->scan_pulang_start_menit,
            'scan_pulang_end' => $this->scan_pulang_end_jam.':'.$this->scan_pulang_end_menit,
        ]);
        if($this->ptk_selected){
            foreach($this->ptk_selected as $ptk_id){
                Jam_ptk::create([
                    'ptk_id' => $ptk_id,
                    'jam_id' => $jam->id,
                ]);
            }
        }
        if($this->hari_selected){
            foreach($this->hari_selected as $hari){
                Jam_hari::create([
                    'nama' => $hari,
                    'jam_id' => $jam->id,
                ]);
            }
        }
        $this->close();
        $this->alert('info', 'Data Jam berhasil disimpan', [
            'position' => 'center'
        ]);
    }
    public function update(){
        $this->setData('update');
        $this->close();
        $this->alert('info', 'Data Jam berhasil diperbaharui', [
            'position' => 'center'
        ]);
    }
    public function delete(){
        $this->setData('delete');
        $this->close();
        $this->alert('info', 'Data Jam berhasil dihapus', [
            'position' => 'center'
        ]);
    }
    private function resetInputFields(){
        $this->reset(['jam_id', 'sekolah_id', 'nama', 'nama', 'is_libur', 'tanggal_mulai', 'tanggal_akhir', 'sekolah', 'isLibur', 'data_ptk', 'hari_selected', 'ptk_selected', 'scan_masuk_start_jam', 'scan_masuk_start_menit', 'scan_masuk_end_jam', 'scan_masuk_end_menit', 'waktu_akhir_masuk_jam', 'waktu_akhir_masuk_menit', 'scan_pulang_start_jam', 'scan_pulang_start_menit', 'scan_pulang_end_jam', 'scan_pulang_end_menit']);
    }
    public function cancel(){
        $this->resetInputFields();
    }
    public function close()
    {
        $this->resetInputFields();
        $this->emit('close-modal');
        $this->resetPage();
    }
    protected $listeners = ['cancel', 'addModal', 'editModal', 'deleteModal', 'detilModal', 'resetData'];
    public function addModal(){
        $this->resetInputFields();
    }
    public function editModal(){
        $this->editMode = TRUE;
        $this->setData('view');
    }
    public function deleteModal(){
    }
    public function detilModal(){
        $this->setData('view');
    }
    public function resetData(){
        $this->resetInputFields();
    }
    public function getID($id){
        $this->jam_id = $id;
        $this->setData('view');
    }
    /*public function updating($name, $value)
    {
        $this->{$name} = $value;
    }*/
    public function setData($action){
        $find = Jam::find($this->jam_id);
        if($action == 'update'){
            $this->validate();
            $find->sekolah_id = $this->sekolah_id;
            $find->nama = $this->nama;
            $find->is_libur = $this->is_libur;
            $find->tanggal_mulai = ($this->tanggal_mulai) ? date('Y-m-d', strtotime($this->tanggal_mulai)) : NULL;
            $find->tanggal_akhir = ($this->tanggal_akhir) ? date('Y-m-d', strtotime($this->tanggal_akhir)) : NULL;
            $find->scan_masuk_start = $this->scan_masuk_start_jam.':'.$this->scan_masuk_start_menit;
            $find->scan_masuk_end = $this->scan_masuk_end_jam.':'.$this->scan_masuk_end_menit;
            $find->waktu_akhir_masuk = $this->waktu_akhir_masuk_jam.':'.$this->waktu_akhir_masuk_menit;
            $find->scan_pulang_start = $this->scan_pulang_start_jam.':'.$this->scan_pulang_start_menit;
            $find->scan_pulang_end = $this->scan_pulang_end_jam.':'.$this->scan_pulang_end_menit;
            $find->save();
            if($this->ptk_selected){
                $ptk_id_delete = [];
                foreach($this->ptk_selected as $ptk_id){
                    $ptk_id_delete[] = $ptk_id;
                    Jam_ptk::updateOrCreate([
                        'ptk_id' => $ptk_id,
                        'jam_id' => $find->id,
                    ]);
                }
                if($ptk_id_delete){
                    Jam_ptk::where('jam_id', $find->id)->whereNotIn('ptk_id', $ptk_id_delete)->delete();
                }
            }
            if($this->hari_selected){
                $hari_delete = [];
                foreach($this->hari_selected as $hari){
                    $hari_delete[] = $hari;
                    Jam_hari::updateOrCreate([
                        'nama' => $hari,
                        'jam_id' => $find->id,
                    ]);
                }
                Jam_hari::where('jam_id', $find->id)->whereNotIn('nama', $hari_delete)->delete();
            }
        } elseif($action == 'delete'){
            $find->delete();
        } else {
            $this->sekolah_id = $find->sekolah_id; 
            $this->nama = $find->nama; 
            $this->is_libur = $find->is_libur; 
            $this->tanggal_mulai = $find->tanggal_mulai; 
            $this->tanggal_akhir = $find->tanggal_akhir; 
            $this->sekolah = $find->sekolah;
            if($find->sekolah_id){
                $this->data_ptk = Ptk::where('sekolah_id', $find->sekolah_id)->select('ptk_id', 'nama')->get();
            }
            if($find->ptk->count()){
                foreach($find->ptk as $ptk){
                    $result_ptk[] = $ptk->ptk->nama;
                    $result_ptk_selected[] = $ptk->ptk_id;
                }
                $this->jam_ptk = collect($result_ptk);
                $this->ptk_selected = $result_ptk_selected;
            } else {
                $this->jam_ptk = '';
                $this->ptk_selected = [];
            }
            if($find->hari->count()){
                foreach($find->hari as $hari){
                    $result_hari[] = $hari->nama;
                    $result_hari_selected[] = $hari->nama;
                }
                $this->jam_hari = collect($result_hari);
                $this->hari_selected = $result_hari_selected;
            } else {
                $this->jam_hari = '';
                $this->hari_selected = [];
            }
            if($find){
                $this->scan_masuk_start = $find->scan_masuk_start;
                $this->scan_masuk_end = $find->scan_masuk_end;
                $this->waktu_akhir_masuk = $find->waktu_akhir_masuk;
                $this->scan_pulang_start = $find->scan_pulang_start;
                $this->scan_pulang_end = $find->scan_pulang_end;
                $collect_scan_masuk_start = collect(explode(':', $find->scan_masuk_start));
                $collect_scan_masuk_start->pop();
                $collect_scan_masuk_end = collect(explode(':', $find->scan_masuk_end));
                $collect_scan_masuk_end->pop();
                $collect_waktu_akhir_masuk = collect(explode(':', $find->waktu_akhir_masuk));
                $collect_waktu_akhir_masuk->pop();
                $collect_scan_pulang_start = collect(explode(':', $find->scan_pulang_start));
                $collect_scan_pulang_start->pop();
                $collect_scan_pulang_end = collect(explode(':', $find->scan_pulang_end));
                $collect_scan_pulang_end->pop();
                $this->scan_masuk_start_jam = $collect_scan_masuk_start->first();
                $this->scan_masuk_start_menit = $collect_scan_masuk_start->last();
                $this->scan_masuk_end_jam = $collect_scan_masuk_end->first();
                $this->scan_masuk_end_menit = $collect_scan_masuk_end->last();
                $this->waktu_akhir_masuk_jam = $collect_waktu_akhir_masuk->first();
                $this->waktu_akhir_masuk_menit = $collect_waktu_akhir_masuk->last();
                $this->scan_pulang_start_jam = $collect_scan_pulang_start->first();
                $this->scan_pulang_start_menit = $collect_scan_pulang_start->last();
                $this->scan_pulang_end_jam = $collect_scan_pulang_end->first();
                $this->scan_pulang_end_menit = $collect_scan_pulang_end->last();
            }
            //$this->hari_selected = ($find->hari->count()) ? $find->hari()->select('nama')->get() : [];
            //$this->ptk_selected = ($find->ptk->count()) ? $find->ptk()->select('ptk_id')->get() : [];
        }
    }
    public function copyJam(){
        
    }
}
