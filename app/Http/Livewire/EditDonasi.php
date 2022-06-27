<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Donasi;

class EditDonasi extends Component
{
    use WithFileUploads;
    public $donasi;
    public $nama;
    public $deskripsi;
    public $nomor_rekening;
    public $nama_rekening;
    public $gambar;
    protected $rules = [
        'nama' => 'required',
        'deskripsi' => 'required',
        'nomor_rekening' => 'required',
        'nama_rekening' => 'required',
        'gambar' => 'required|image|max:1024',
    ];
    protected $messages = [
        'nama.required' => 'Nama Donasi tidak boleh kosong.',
        'deskripsi.required' => 'Deskripsi tidak boleh kosong.',
        'nomor_rekening.required' => 'Nomor Rekening tidak boleh kosong.',
        'nama_rekening.required' => 'Nama Rekening tidak boleh kosong.',
        'gambar.required' => 'Gambar tidak boleh kosong.',
        'gambar.image' => 'Berkas yang di upload harus berupa image.',
    ];
    public function mount($id)
    {
        $this->donasi = Donasi::find($id);
    }
    public function render()
    {
        $donasi = $this->donasi;
        $this->nama = 'mana';//$donasi->judul;
        //$this->deskripsi = $donasi->deskripsi;
        $this->deskripsi = 'duh';
        //$donasi = Donasi::find();
        return view('livewire.edit-donasi');
    }
    public function update(){
        $this->validate();
        dd($this->donasi);
    }
}
