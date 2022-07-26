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
        if(!File::exists(storage_path('app/public/qrcodes/'.$user->pd->peserta_didik_id.'.png'))){
            QrCode::size(250)->format('png')->generate($user->pd->peserta_didik_id, storage_path('app/public/qrcodes/'.$user->pd->peserta_didik_id.'.png'));
        }
        return view('livewire.profile.barcode',[
            'user' => $user,
        ]);
    }
    public function downloadQrCode(){
        $user = $this->loggedUser();
        return response()->download(storage_path('app/public/qrcodes/'.$user->pd->peserta_didik_id.'.png'));
    }
    public function loggedUser(){
        return auth()->user();
    }
}
