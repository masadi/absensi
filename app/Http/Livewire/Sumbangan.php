<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Donasi;
use App\Models\Dana;
class Sumbangan extends Component
{
    use WithFileUploads, WithPagination;
    public $updateMode = false;
    public $donasi_id, $deleteId, $nama, $deskripsi, $nomor_rekening, $nama_rekening, $gambar, $data;
    public $penyumbang_id, $nominal, $nama_bank, $nomor_pengirim, $nama_pengirim, $bukti;
    protected $paginationTheme = 'bootstrap';
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
        $user = auth()->user();
        return view('livewire.sumbangan', ['donasi' => Donasi::paginate(5), 'data' => '', 'user' => $user, 'riwayat' => '']);
    }
    private function resetInputFields(){
        $this->nama = '';
        $this->deskripsi = '';
        $this->nomor_rekening = '';
        $this->nama_rekening = '';
        $this->gambar = '';
    }
    public function store(){
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
        session()->flash('message', 'Users Created Successfully.');
        $this->resetInputFields();
        $this->emit('create');
        //return redirect()->route('list_donasi',);
    }
    public function edit($id)
    {
        $this->updateMode = true;
        $donasi = Donasi::find($id);
        $this->donasi_id = $id;
        $this->nama = $donasi->judul;
        $this->deskripsi = $donasi->deskripsi;
        $this->nomor_rekening = $donasi->nomor_rekening;
        $this->nama_rekening = $donasi->nama_rekening;
        $this->gambar = $donasi->gambar;
    }
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }
    public function update()
    {
        if ($this->donasi_id) {
            $donasi = Donasi::find($this->donasi_id);
            //$filename = $this->gambar->store('public/gambar');
            $gambar = '';//collect(explode('/', $filename))->last();
            $donasi->update([
                'judul' => $this->nama,
                'deskripsi' => $this->deskripsi,
                'nomor_rekening' => $this->nomor_rekening,
                'nama_rekening' => $this->nama_rekening,
                'gambar' => $gambar,
            ]);
            $this->updateMode = false;
            session()->flash('message', 'Users Updated Successfully.');
            $this->resetInputFields();
            $this->emit('update');
        } else {
            session()->flash('message', 'Users Updated asdcancel.');
        }
    }
    public function deleteId($id)
    {
        $this->deleteId = $id;
    }
    public function delete()
    {
        if($this->deleteId){
            Donasi::where('id',$this->deleteId)->delete();
            session()->flash('message', 'Users Deleted Successfully.');
        }
        $this->emit('delete');
    }
    public function donasi($id)
    {
        $this->resetValidation();
        $this->penyumbang_id = auth()->user()->id;
        $this->donasi_id = $id;
        $this->data = Donasi::find($id);
        $this->nominal = '';
        $this->nomor_pengirim = '';
        $this->nama_pengirim = '';
        $this->bukti = NULL;
    }
    public function proses(){
        //public $penyumbang_id, $nominal, $nomor_pengirim, $nama_pengirim, $bukti;
        $validatedData = $this->validate(
            [
                'nominal' => 'required|int',
                'nomor_pengirim' => 'required|int',
                'nama_pengirim' => 'required',
                'bukti' => 'required|image|max:1024',
                'nama_bank' => 'required',
            ],
            [
                'nominal.required' => 'Nominal tidak boleh kosong',
                'nominal.int' => 'Nominal harus berupa angka',
                'nama_bank.required' => 'Nama Bank tidak boleh kosong',
                'nomor_pengirim.required' => 'Nomor Rekening tidak boleh kosong',
                'nomor_pengirim.int' => 'Nomor Rekening harus berupa angka',
                'nama_pengirim.required' => 'Nama Rekening tidak boleh kosong',
                'bukti.required' => 'Bukti Transfer tidak boleh kosong.',
                'bukti.image' => 'Berkas yang di upload harus berupa image.',
                'bukti.max' => 'Berkas yang di upload melebihi ukuran yang diperbolehkan.',
            ],

        );
        $filename = $this->bukti->store('public/bukti');
        $bukti = collect(explode('/', $filename))->last();
        Dana::create([
            'user_id' => $this->penyumbang_id,
            'donasi_id' => $this->donasi_id,
            'nominal' => $this->nominal,
            'nama_bank' => $this->nama_bank,
            'nomor_pengirim' => $this->nomor_pengirim,
            'nama_pengirim' => $this->nama_pengirim,
            'bukti' => $bukti,
        ]);
        //$a = $this->nominal;
        $this->emit('donasi');
    }
    public function riwayat($donasi_id, $user_id){
        $this->riwayat = Dana::where('donasi_id', $donasi_id)->where('user_id', $user_id)->get();
        //dump($donasi_id);
        //dd($user_id);
    }
}
