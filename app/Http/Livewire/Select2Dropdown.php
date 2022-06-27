<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
class Select2Dropdown extends Component
{
    public $select_id, $title, $placeholder, $url, $modalId, $value, $model;
    public function mount($data)
    {
        $this->select_id = $data['id'];
        $this->title = $data['title'];
        $this->placeholder = $data['placeholder'];
        $this->url = $data['url'];
        $this->modalId = $data['modalId'];
        $this->value = $data['value'];
        $this->model = $data['model'];
        //$this->title = $post->content;
    }
    
    public function render()
    {
        //$provinsi = Province::all();
        return view('livewire.select2-dropdown');
    }
}
