<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Setting;

class Pengaturan extends Component
{
    public $scan_masuk_start_jam;
    public $scan_masuk_start_menit;
    public $scan_masuk_end_jam;
    public $scan_masuk_end_menit;
    public $scan_pulang_start_jam;
    public $scan_pulang_start_menit;
    public $scan_pulang_end_jam;
    public $scan_pulang_end_menit;
    protected $rules = [
        'scan_masuk_start_jam' => 'required',
        'scan_masuk_end_jam' => 'required',
        'scan_pulang_start_jam' => 'required',
        'scan_pulang_end_jam' => 'required',
        'scan_masuk_start_menit' => 'required',
        'scan_masuk_end_menit' => 'required',
        'scan_pulang_start_menit' => 'required',
        'scan_pulang_end_menit' => 'required',
    ];
    protected $messages = [
        'scan_masuk_start_jam.required' => 'Jam Absen Masuk Awal tidak boleh kosong!!',
        'scan_masuk_end_jam.required' => 'Jam Absen Masuk Akhir tidak boleh kosong!',
        'scan_pulang_start_jam.required' => 'Jam Absen Pulang Awal tidak boleh kosong!!',
        'scan_pulang_end_jam.required' => 'Jam Absen Pu;ang Akhir tidak boleh kosong!',
        'scan_masuk_start_menit.required' => 'Menit Absen Masuk Awal tidak boleh kosong!!',
        'scan_masuk_end_menit.required' => 'Menit Absen Masuk Akhir tidak boleh kosong!',
        'scan_pulang_start_menit.required' => 'Menit Absen Pulang Awal tidak boleh kosong!!',
        'scan_pulang_end_menit.required' => 'Menit Absen Pu;ang Akhir tidak boleh kosong!',
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function mount()
    {
        $this->scan_masuk_start_jam = config('settings.scan_masuk_start_jam');
        $this->scan_masuk_end_jam = config('settings.scan_masuk_end_jam');
        $this->scan_pulang_start_jam = config('settings.scan_pulang_start_jam');
        $this->scan_pulang_end_jam = config('settings.scan_pulang_end_jam');
        $this->scan_masuk_start_menit = config('settings.scan_masuk_start_menit');
        $this->scan_masuk_end_menit = config('settings.scan_masuk_end_menit');
        $this->scan_pulang_start_menit = config('settings.scan_pulang_start_menit');
        $this->scan_pulang_end_menit = config('settings.scan_pulang_end_menit');
    }
    public function save()
    {
        $this->validate();
        $data = ['scan_masuk_start_jam', 'scan_masuk_end_jam', 'scan_pulang_start_jam', 'scan_pulang_end_jam', 'scan_masuk_start_menit', 'scan_masuk_end_menit', 'scan_pulang_start_menit', 'scan_pulang_end_menit'];
        foreach($data as $d){
            Setting::updateOrcreate(
                [
                    'key' => $d,
                ],
                [
                    'value' => $this->{$d},
                ]
            );
        }
        Setting::updateOrcreate(
            [
                'key' => 'scan_masuk_start',
            ],
            [
                'value' => $this->scan_masuk_start_jam.':'.$this->scan_masuk_start_menit,
            ]
        );
        Setting::updateOrcreate(
            [
                'key' => 'scan_masuk_end',
            ],
            [
                'value' => $this->scan_masuk_end_jam.':'.$this->scan_masuk_end_menit,
            ]
        );
        Setting::updateOrcreate(
            [
                'key' => 'scan_pulang_start',
            ],
            [
                'value' => $this->scan_pulang_start_jam.':'.$this->scan_pulang_start_menit,
            ]
        );
        Setting::updateOrcreate(
            [
                'key' => 'scan_pulang_end',
            ],
            [
                'value' => $this->scan_pulang_end_jam.':'.$this->scan_pulang_end_menit,
            ]
        );
    }
    public function render()
    {
        /*$this->scan_masuk_start = config('settings.scan_masuk_start');
        $this->scan_masuk_end = config('settings.scan_masuk_end');
        $this->scan_pulang_start = config('settings.scan_pulang_start');
        $this->scan_pulang_end = config('settings.scan_pulang_end');*/
        return view('livewire.pengaturan');
    }
}
