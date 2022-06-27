<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Regency;
use App\Models\Dpw as DpwModel;
Use Auth;
class Dpw extends Component
{
    public $dpw = '';
    public $selected = NULL;
    public function render()
    {
        $user = Auth::user();
        $this->dpw = $user->dpw_id;
        $this->selected = ($this->dpw) ? DpwModel::find($this->dpw) : NULL;
        return view('livewire.dpw');
    }
    public function kabupaten(Request $request){
        $regencies = Regency::select('id', 'name as text')->where('name', 'LIKE', '%'.$request->q.'%')->paginate(10);
        return response()->json(['results' => $regencies, 'pagination' => true]);
    }
    public function updatedDpw(){
        $user = Auth::user();
        $user->dpw_id = $this->dpw;
        $user->save();
    }
}
