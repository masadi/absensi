<?php

namespace App\Http\Livewire;

use Maatwebsite\Excel\Facades\Excel;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Imports\UsersImport;
use App\Models\User;

class AlumniAktif extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $data, $excel;
    public function render()
    {
        $user = auth()->user();
        return view('livewire.alumni-aktif', ['results' => User::role('alumni')->where(function($query) use ($user){
            if($user->hasRole('dpw')){
                $query->where('regency_id', $user->regency_id);
            }
        })->paginate(10)]);
    }
    public function detil($id){
        $this->data = User::find($id);
    }
    public function store(){
        Excel::import(new UsersImport, $this->excel);
        $this->emit('create');
    }
}
