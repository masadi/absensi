<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Jam;
use App\Models\Sekolah;
use App\Models\Kategori;
use Carbon\Carbon;

class DataJam extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $sortby = 'created_at';
    public $sortbydesc = 'DESC';
    public $per_page = 10;
    public $data_kategori = [];
    public $kategori;
    public $jam_id;
    public $sekolah_id;
    public $kategori_id;
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
    //db
    public $scan_masuk_start;
    public $scan_masuk_end;
    public $waktu_akhir_masuk;
    public $scan_pulang_start;
    public $scan_pulang_end;

    protected $rules = [
        'kategori_id' => 'required',
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
    ];
    protected $messages = [
        'kategori_id.required' => 'Kategori tidak boleh kosong!!',
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

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function loadPerPage(){
        $this->resetPage();
    }
    public function render()
    {
        return view('livewire.data-jam', [
            'data_jam' => Jam::with(['kategori' => function($query){
                $query->select('id', 'nama');
            }])->orderBy($this->sortby, $this->sortbydesc)
                ->when($this->search, function($data) {
                    $data->whereHas('kategori', function($query){
                        $query->where('nama', 'ILIKE', '%' . $this->search . '%');
                    });
            })->paginate($this->per_page),
            'data_sekolah' => Sekolah::get(),
        ]);
    }
    public function getKategori(){
        $this->data_kategori = Kategori::where(function($query){
            if($this->sekolah_id){
                $query->where('sekolah_id', $this->sekolah_id);
            } else {
                $query->whereNull('sekolah_id');
            }
        })->get();
    }
    public function save(){
        $this->validate();
        Jam::create([
            'kategori_id' => $this->kategori_id,
            'scan_masuk_start' => $this->scan_masuk_start_jam.':'.$this->scan_masuk_start_menit,
            'scan_masuk_end' => $this->scan_masuk_end_jam.':'.$this->scan_masuk_end_menit,
            'waktu_akhir_masuk' => $this->waktu_akhir_masuk_jam.':'.$this->waktu_akhir_masuk_menit,
            'scan_pulang_start' => $this->scan_pulang_start_jam.':'.$this->scan_pulang_start_menit,
            'scan_pulang_end' => $this->scan_pulang_end_jam.':'.$this->scan_pulang_end_menit,
        ]);
        $this->close();
        $this->alert('info', 'Data kategori berhasil disimpan', [
            'position' => 'center'
        ]);
    }
    public function close()
    {
        $this->reset(['sekolah_id', 'kategori_id', 'scan_masuk_start_jam', 'scan_masuk_start_menit', 'scan_masuk_end_jam', 'scan_masuk_end_menit', 'waktu_akhir_masuk_jam', 'waktu_akhir_masuk_menit', 'scan_pulang_start_jam', 'scan_pulang_start_menit', 'scan_pulang_end_jam', 'scan_pulang_end_menit']);
        $this->emit('close-modal');
        $this->resetPage();
    }
    public function getID($id){
        $this->jam_id = $id;
        $this->setData('view');
    }
    public function setData($action){
        $find = Jam::find($this->jam_id);
        if($action == 'update'){
            $find->kategori_id = $this->kategori_id;
            $find->scan_masuk_start = $this->scan_masuk_start_jam.':'.$this->scan_masuk_start_menit;
            $find->scan_masuk_end = $this->scan_masuk_end_jam.':'.$this->scan_masuk_end_menit;
            $find->waktu_akhir_masuk = $this->waktu_akhir_masuk_jam.':'.$this->waktu_akhir_masuk_menit;
            $find->scan_pulang_start = $this->scan_pulang_start_jam.':'.$this->scan_pulang_start_menit;
            $find->scan_pulang_end = $this->scan_pulang_end_jam.':'.$this->scan_pulang_end_menit;
            return $find->save();
        } elseif($action == 'delete'){
            return $find->delete();
        } else {
            $this->reset(['sekolah_id', 'kategori_id', 'scan_masuk_start_jam', 'scan_masuk_start_menit', 'scan_masuk_end_jam', 'scan_masuk_end_menit', 'waktu_akhir_masuk_jam', 'waktu_akhir_masuk_menit', 'scan_pulang_start_jam', 'scan_pulang_start_menit', 'scan_pulang_end_jam', 'scan_pulang_end_menit']);
            $this->sekolah_id = $find->kategori->sekolah_id;
            $this->kategori_id = $find->kategori_id;
            $this->scan_masuk_start_jam = collect(explode(':', $find->scan_masuk_start))->first();
            $this->scan_masuk_start_menit = collect(explode(':', $find->scan_masuk_start))->last();
            $this->scan_masuk_end_jam = collect(explode(':', $find->scan_masuk_end))->first();
            $this->scan_masuk_end_menit = collect(explode(':', $find->scan_masuk_end))->last();
            $this->waktu_akhir_masuk_jam = collect(explode(':', $find->waktu_akhir_masuk))->first();
            $this->waktu_akhir_masuk_menit = collect(explode(':', $find->waktu_akhir_masuk))->last();
            $this->scan_pulang_start_jam = collect(explode(':', $find->scan_pulang_start))->first();
            $this->scan_pulang_start_menit = collect(explode(':', $find->scan_pulang_start))->last();
            $this->scan_pulang_end_jam = collect(explode(':', $find->scan_pulang_end))->first();
            $this->scan_pulang_end_menit = collect(explode(':', $find->scan_pulang_end))->last();
            //db
            $this->scan_masuk_start = $find->scan_masuk_start;
            $this->scan_masuk_end = $find->scan_masuk_end;
            $this->waktu_akhir_masuk = $find->waktu_akhir_masuk;
            $this->scan_pulang_start = $find->scan_pulang_start;
            $this->scan_pulang_end = $find->scan_pulang_end;
            $this->getKategori();
        }
    }
    public function update(){
        $this->setData('update');
        $this->close();
        $this->alert('info', 'Data jam berhasil diperbaharui', [
            'position' => 'center'
        ]);
    }
    public function delete(){
        $this->setData('delete');
        $this->close();
        $this->alert('info', 'Data jam berhasil dihapus', [
            'position' => 'center'
        ]);
    }
}
