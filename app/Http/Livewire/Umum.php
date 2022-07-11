<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Semester;
use App\Models\Setting;

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
            'data_semester' => Semester::get(),
        ]);
    }
    public function mount()
    {
        $jarak = Setting::where('key', 'jarak')->first();
        $this->semester_id = Semester::where('periode_aktif', 1)->first()->semester_id;
        $this->jarak = ($jarak) ? $jarak->value : '';
    }
    public function save(){
        //
        $this->validate();
        Semester::where('semester_id', '<>', $this->semester_id)->update(['periode_aktif' => 0]);
        Semester::where('semester_id', $this->semester_id)->update(['periode_aktif' => 1]);
        Setting::updateOrCreate(
            ['key' => 'jarak'],
            ['value' => $this->jarak]
        );
        session()->flash('message', 'Pengaturan berhasil disimpan.');
    }
}
