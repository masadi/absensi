<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Semester;
use App\Models\Setting;
use App\Models\Team;
use App\Models\User;

class Umum extends Component
{
    public $showForm,
            $semester_id,
            $jarak;
    protected $rules = [
        'semester_id' => 'required',
        'jarak' => 'required',
    ];
    protected $messages = [
        'semester_id.required' => 'Semester Aktif tidak boleh kosong!!',
        'jarak.required' => 'Jarak Maksimum tidak boleh kosong!!',
    ];
    public function render()
    {
        return view('livewire.umum', [
            'data_semester' => Semester::orderBy('semester_id', 'DESC')->get(),
        ]);
    }
    public function mount()
    {
        $jarak = Setting::where('key', 'jarak')->first();
        $this->semester_id = Semester::where('periode_aktif', 1)->first()->semester_id;
        $this->jarak = ($jarak) ? $jarak->value : '';
    }
    public function save(){
        $user = auth()->user();
        $this->validate();
        $semester = Semester::find($this->semester_id);
        $team = Team::firstOrCreate([
            'name' => $semester->nama,
            'display_name' => $semester->nama,
            'description' => $semester->nama,
        ]);
        if(!$user->hasRole('administrator', $team)){
            $user->attachRole('administrator', $team);
        }
        $semester->periode_aktif = 1;
        $semester->save();
        $roles = ['administrator', 'ptk', 'staf', 'pd'];
        $get_users = User::whereRoleIs($roles, $semester->nama)->select('id')->get();
        foreach($get_users as $user){
            $user_id[] = $user->id;
        }
        $users = User::whereNotIn('id', $user_id)->get();
        foreach($users as $user){
            if($user->has('ptk')){
                if(!$user->hasRole('ptk', $team)){
                    $user->attachRole('ptk', $team);
                }
            }
            if($user->has('pd')){
                if(!$user->hasRole('pd', $team)){
                    $user->attachRole('pd', $team);
                }
            }
            if($user->has('staf')){
                if(!$user->hasRole('staf', $team)){
                    $user->attachRole('staf', $team);
                }
            }
        }
        Setting::updateOrCreate(
            ['key' => 'jarak'],
            ['value' => $this->jarak]
        );
        Semester::where('semester_id', '<>', $this->semester_id)->update(['periode_aktif' => 0]);
        session()->flash('message', 'Pengaturan berhasil disimpan.');
    }
}
