<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\UsersImport as ImportUsers;

class UsersImport extends Component
{
    //use WithFileUploads, ImportUsers;
    public function render()
    {
        return view('livewire.users-import');
    }
}
