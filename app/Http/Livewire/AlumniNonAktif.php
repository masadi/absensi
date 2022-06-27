<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Str;

class AlumniNonAktif extends Component
{
    use WithPagination;
    public $data;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $user = auth()->user();
        return view('livewire.alumni-non-aktif', ['results' => User::doesntHave('roles')->where(function($query) use ($user){
            if($user->hasRole('dpw')){
                $query->where('regency_id', $user->regency_id);
            }
        })->paginate(10), 'data' => '']);
    }
    public function detil($id){
        $this->data = User::find($id);
    }
    public function deleteId($id)
    {
        $this->deleteId = $id;
    }
    public function delete()
    {
        if($this->deleteId){
            $hitung = User::role('alumni')->count();
            $user = User::find($this->deleteId);
            $urut = Str::padLeft($hitung, 6, '0');
            $user->nomor_induk = $user->tahun_lulus.$urut;
            $user->save();
            $user->assignRole('alumni');
            session()->flash('message', 'Data alumni berhasil disetujui.');
        }
        $this->emit('delete');
    }
}
