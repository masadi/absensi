<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Kegiatan;
use App\Models\Kehadiran;

class Kegiatans extends Component
{
    use WithPagination;
    public $updateMode = false;
    public $kegiatan_id, $deleteId, $user_id, $nama, $waktu, $tempat, $regency_id, $hadirId;
    protected $paginationTheme = 'bootstrap';
    protected $rules = [
        'nama' => 'required',
        'waktu' => 'required',
        'tempat' => 'required',
    ];
    protected $messages = [
        'nama.required' => 'Nama Donasi tidak boleh kosong.',
        'waktu.required' => 'Waktu Kegiatan tidak boleh kosong.',
        'tempat.required' => 'Tempat Kegiatan tidak boleh kosong.',
    ];
    protected $listeners = ['setWaktu'];
    public function setWaktu($value){
        $this->waktu = $value;
    }
    public function render()
    {
        $user = auth()->user();
        $this->user_id = $user->id;
        $this->regency_id = $user->regency_id;
        return view('livewire.kegiatans', ['results' => Kegiatan::orderBy('created_at', 'DESC')->paginate(10), 'user' => $user]);
    }
    private function resetInputFields(){
        $this->user_id = '';
        $this->nama = '';
        $this->waktu = '';
        $this->tempat = '';
        $this->regency_id = '';
    }
    public function store(){
        $this->validate();
        Kegiatan::create([
            'user_id' => $this->user_id,
            'nama' => $this->nama,
            'waktu' => date('Y-m-d', strtotime($this->waktu)),
            'tempat' => $this->tempat,
            'regency_id' => $this->regency_id,
        ]);
        session()->flash('message', 'Kegiatan berhasil disimpan.');
        $this->resetInputFields();
        $this->emit('create');
    }
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }
    public function edit($id)
    {
        $this->updateMode = true;
        $kegiatan = Kegiatan::find($id);
        $this->kegiatan_id = $id;
        $this->user_id = $kegiatan->user_id;
        $this->nama = $kegiatan->nama;
        $this->waktu = $kegiatan->waktu;
        $this->tempat = $kegiatan->tempat;
        $this->regency_id = $kegiatan->regency_id;
    }
    public function update()
    {
        if ($this->kegiatan_id) {
            $kegiatan = Kegiatan::find($this->kegiatan_id);
            $kegiatan->update([
                'nama' => $this->nama,
                'waktu' => date('Y-m-d', strtotime($this->waktu)),
                'tempat' => $this->tempat,
                'regency_id' => $this->regency_id,
            ]);
            $this->updateMode = false;
            session()->flash('message', 'Kegiatan berhasil diperbaharui');
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
            Kegiatan::where('id',$this->deleteId)->delete();
            session()->flash('message', 'Kegiatan berhasil dihapus.');
        }
        $this->emit('delete');
    }
    public function hadirId($id){
        $this->hadirId = $id;
    }
    public function hadir(){
        if($this->hadirId){
            Kehadiran::updateOrCreate([
                'user_id' => auth()->user()->id,
                'kegiatan_id' => $this->hadirId,
            ]);
            session()->flash('message', 'Kehadiran berhasil disimpan.');
        }
        $this->emit('hadir');
    }
    public function batal(){
        if($this->hadirId){
            $kehadiran = Kehadiran::where('user_id', auth()->user()->id)->where('kegiatan_id',$this->hadirId)->first();
            if($kehadiran){
                $kehadiran->delete();
            }
            session()->flash('message', 'Kehadiran berhasil dibatalkan.');
        }
        $this->emit('batal');
    }
}
