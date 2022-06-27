<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use App\Models\User;
use App\Models\Dana;

class DashboardAdmin extends Component
{
    public function render()
    {
        $user = auth()->user();
        return view('livewire.dashboard-admin', [
            'user' => $user,
            'jml_alumni' => User::whereDoesntHave('roles', function(Builder $query){
                $query->where('name', 'admin');
            })->count(),
            'jml_verif' => User::role('alumni')->where(function($query) use ($user){
                if($user->hasRole('dpw')){
                    $query->where('regency_id', $user->regency_id);
                }
            })->count(),
            'jml_non_verif' => User::doesntHave('roles')->where(function($query) use ($user){
                if($user->hasRole('dpw')){
                    $query->where('regency_id', $user->regency_id);
                }
            })->count(),
            'donasi' => number_format(Dana::sum('nominal'), 0, '.', '.'),
        ]);
    }
}
