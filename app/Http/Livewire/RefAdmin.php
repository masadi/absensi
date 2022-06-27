<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class RefAdmin extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $dpw_id, $deleteId, $name, $email, $user_id;
    protected $listeners = ['dpw_id'];
    public function render()
    {
        return view('livewire.ref-admin', [
            'results' => User::role('dpw')->paginate(10),
        ]);
    }
    public function dpw_id($value){
        $this->dpw_id = $value;
    }
    public function store(){
        $validatedData = $this->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'dpw_id' => 'required|exists:dpw,id',
            ],
            [
                'name.required' => 'Nama Lengkap tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'email.email' => 'Email tidak valid',
                'email.unique' => 'Email sudah terdaftar di aplikasi',
                'dpw_id.required' => 'Nama DPW tidak boleh kosong',
                'dpw_id.exists' => 'Nama DPW belum terdaftar di aplikasi',
            ],

        );
        $this->resetValidation();
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'dpw_id' => $this->dpw_id,
            'password' => bcrypt(12345678),
        ]);
        $user->assignRole('dpw');
        $this->resetInputFields();
        $this->emit('create');
    }
    private function resetInputFields(){
        $this->name = '';
        $this->email = '';
        $this->dpw_id = '';
    }
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }
    public function edit($id)
    {
        $this->resetInputFields();
        $this->updateMode = true;
        $data = User::find($id);
        $this->user_id = $id;
        $this->name = $data->name;
        $this->email = $data->email;
        $this->dpw_id = $data->dpw_id;
    }
    public function update()
    {
        if ($this->user_id) {
            $data = User::find($this->user_id);
            $data->update([
                'name' => $this->name,
                'email' => $this->email,
                'dpw_id' => $this->dpw_id,
            ]);
            $this->updateMode = false;
            session()->flash('message', 'Data berhasil diperbaharui');
            $this->resetInputFields();
            $this->emit('update');
        }
    }
    public function deleteId($id)
    {
        $this->deleteId = $id;
    }
    public function delete()
    {
        if($this->deleteId){
            User::where('id',$this->deleteId)->delete();
            session()->flash('message', 'Data berhasil dihapus.');
        }
        $this->emit('delete');
    }
}
