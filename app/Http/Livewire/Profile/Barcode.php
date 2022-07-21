<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Peserta_didik;
use File;

class Barcode extends Component
{
    public function render()
    {
        $user = $this->loggedUser();
        $folder = storage_path('app/public/qrcodes');
        if (!File::isDirectory($folder)) {
            //MAKA FOLDER TERSEBUT AKAN DIBUAT
            File::makeDirectory($folder, 0777, true, true);
        }
        if(!File::exists(storage_path('app/public/qrcodes/'.$user->pd->peserta_didik_id.'.svg'))){
            QrCode::size(250)->generate($user->pd->peserta_didik_id, storage_path('app/public/qrcodes/'.$user->pd->peserta_didik_id.'.svg'));
        }
        return view('livewire.profile.barcode',[
            'user' => $user,
        ]);
    }
    public function downloadQrCode(){
        $user = $this->loggedUser();
        return response()->download(storage_path('app/public/qrcodes/'.$user->pd->peserta_didik_id.'.svg'));
    }
    public function loggedUser(){
        return auth()->user();
    }
}
