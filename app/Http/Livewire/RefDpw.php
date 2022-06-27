<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Dpw;

class RefDpw extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['ketua_id', 'sekretaris_id', 'bendahara_id'];
    public $nama, $alamat;//, $ketua_id, $sekretaris_id, $bendahara_id;
    public $dpw_id, $deleteId, $nama_ketua, $nama_sekretaris, $nama_bendahara;
    public function render()
    {
        return view('livewire.ref-dpw', [
            'results' => Dpw::paginate(10),
        ]);
    }
    public function ketua_id($value){
        $this->ketua_id = $value;
    }
    public function sekretaris_id($value){
        $this->sekretaris_id = $value;
    }
    public function bendahara_id($value){
        $this->bendahara_id = $value;
    }
    public function store(){
        $validatedData = $this->validate(
            [
                'nama' => 'required',
                'alamat' => 'required',
                'nama_ketua' => 'required',
                'nama_sekretaris' => 'required',
                'nama_bendahara' => 'required',
                //'ketua_id' => 'required|exists:users,id',
                //'sekretaris_id' => 'required|exists:users,id',
                //'bendahara_id' => 'required|exists:users,id',
            ],
            [
                'nama.required' => 'Nama DPW tidak boleh kosong',
                'alamat.required' => 'Alamat Kantor tidak boleh kosong',
                'nama_ketua.required' => 'Nama Ketua tidak boleh kosong',
                'nama_sekretaris.required' => 'Nama Sekretaris tidak boleh kosong',
                'nama_bendahara.required' => 'Nama Bendahara tidak boleh kosong',
                //'ketua_id.required' => 'Nama Ketua tidak boleh kosong',
                //'ketua_id.exists' => 'Nama Ketua belum terdaftar di aplikasi',
                //'sekretaris_id.required' => 'Nama Sekretaris tidak boleh kosong',
                //'sekretaris_id.exists' => 'Nama Sekretaris belum terdaftar di aplikasi',
                //'bendahara_id.required' => 'Nama Bendahara tidak boleh kosong',
                //'bendahara_id.exists' => 'Nama Bendahara belum terdaftar di aplikasi',
            ],

        );
        $this->resetValidation();
        Dpw::create([
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            //'ketua_id' => $this->ketua_id,
            //'sekretaris_id' => $this->sekretaris_id,
            //'bendahara_id' => $this->bendahara_id,
            'nama_ketua' => $this->nama_ketua,
            'nama_sekretaris' => $this->nama_sekretaris,
            'nama_bendahara' => $this->nama_bendahara,
        ]);
        $this->resetInputFields();
        $this->emit('create');
    }
    private function resetInputFields(){
        $this->nama = '';
        $this->alamat = '';
        //$this->ketua_id = '';
        //$this->sekretaris_id = '';
        //$this->bendahara_id = '';
        $this->nama_ketua = '';
        $this->nama_sekretaris = '';
        $this->nama_bendahara = '';
    }
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }
    public function edit($id)
    {
        $this->resetInputFields();
        $this->updateMode = true;
        $data = Dpw::find($id);
        $this->dpw_id = $id;
        $this->nama = $data->nama;
        $this->alamat = $data->alamat;
        /*$this->ketua_id = $data->ketua_id;
        $this->sekretaris_id = $data->sekretaris_id;
        $this->bendahara_id = $data->bendahara_id;
        $this->nama_ketua = $data->ketua->name;
        $this->nama_sekretaris = $data->sekretaris->name;
        $this->nama_bendahara = $data->bendahara->name;*/
        $this->nama_ketua = $data->nama_ketua;
        $this->nama_sekretaris = $data->nama_sekretaris;
        $this->nama_bendahara = $data->nama_bendahara;
    }
    public function update()
    {
        if ($this->dpw_id) {
            $data = Dpw::find($this->dpw_id);
            $data->update([
                'nama' => $this->nama,
                'alamat' => $this->alamat,
                //'ketua_id' => $this->ketua_id,
                //'sekretaris_id' => $this->sekretaris_id,
                //'bendahara_id' => $this->bendahara_id,
                'nama_ketua' => $this->nama_ketua,
                'nama_sekretaris' => $this->nama_sekretaris,
                'nama_bendahara' => $this->nama_bendahara,
            ]);
            $this->updateMode = false;
            session()->flash('message', 'Data berhasil diperbaharui');
            $this->resetInputFields();
            $this->emit('update');
        }
    }
    public function deleteId($id)
    {
        $this->deleteId = $id;
    }
    public function delete()
    {
        if($this->deleteId){
            Dpw::where('id',$this->deleteId)->delete();
            session()->flash('message', 'Data berhasil dihapus.');
        }
        $this->emit('delete');
    }
}
