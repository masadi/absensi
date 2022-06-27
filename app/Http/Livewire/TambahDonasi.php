<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Donasi;

class TambahDonasi extends Component
{
    use WithFileUploads;
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
    public function render()
    {
        $this->deskripsi = 'duh';
        return view('livewire.tambah-donasi');
    }
    public function save(){
        $this->validate();
        $filename = $this->gambar->store('public/gambar');
        $gambar = collect(explode('/', $filename))->last();
        Donasi::create([
            'user_id' => auth()->user()->id,
            'judul' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'nomor_rekening' => $this->nomor_rekening,
            'nama_rekening' => $this->nama_rekening,
            'gambar' => $gambar,
        ]);
        return redirect()->route('list_donasi',);
    }
}
