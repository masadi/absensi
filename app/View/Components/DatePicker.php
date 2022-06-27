<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DatePicker extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public $format = 'DD-MM-YYYY';
    public $name = 'tanggal_lahir';
    public $id = 'id';
    public $placeholder = 'placeholder';
    public $value = '';
    public $tanggal_lahir = '';
    public function render()
    {
        return view('components.date-picker');
    }
}
