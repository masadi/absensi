<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use App\Models\User;

class UpdateProfileSosmed extends Component
{
    public $user_id, $whatsapp, $facebook, $instagram, $youtube, $tiktok, $twitter;
    public function render()
    {
        $user = auth()->user();
        $this->user_id = $user->id;
        $this->whatsapp = $user->whatsapp;
        $this->facebook = $user->facebook;
        $this->instagram = $user->instagram;
        $this->youtube = $user->youtube;
        $this->tiktok = $user->tiktok;
        $this->twitter = $user->twitter;
        return view('livewire.profile.update-profile-sosmed');
    }
    public function store(){
        $user = User::find($this->user_id);
        $user->whatsapp = $this->whatsapp;
        $user->facebook = $this->facebook;
        $user->instagram = $this->instagram;
        $user->youtube = $this->youtube;
        $user->tiktok = $this->tiktok;
        $user->twitter = $this->twitter;
        $user->save();
        return redirect()->route('profile.show');
    }
}
