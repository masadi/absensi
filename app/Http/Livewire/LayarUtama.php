<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Rombongan_belajar;
use Carbon\Carbon;

class LayarUtama extends Component
{
    public $collection = [];
    public $data_kelas = [];
    public function getListeners()
    {
        return [
            'newScan',
        ];
    }
    public function render()
    {
        return view('livewire.layar-utama');
    }
    public function newScan($params){
        $this->reset(['data_kelas']);
        if(count($this->collection) == 20){
            $this->collection->pop();
        }
        $collection = collect($this->collection);
        $merged = $collection->merge([$params]);
        $sorted = $merged->sortByDesc('updated_at');
        $this->collection = $sorted->values()->all();
        $this->data_kelas = Rombongan_belajar::whereHas('anggota_rombel', function($query){
            $query->whereHas('peserta_didik', function($query){
                $query->whereHas('absen', function($query){
                    $query->whereDate('created_at', Carbon::today());
                });
            });
        })->withCount([
            'anggota_rombel as hadir' => function($query){
                $query->whereHas('peserta_didik', function($query){
                    $query->whereHas('absen', function($query){
                        $query->whereDate('created_at', Carbon::today());
                    });
                });
            },
            'anggota_rombel as belum' => function($query){
                $query->whereHas('peserta_didik', function($query){
                    $query->whereDoesntHave('absen', function($query){
                        $query->whereDate('created_at', Carbon::today());
                    });
                });
            }
        ])->limit(20)->get();
    }
}
