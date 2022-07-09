<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;
use App\Models\Semester;

class LoginSuccessful
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $semester = Semester::where('semester_id', $this->request->semester)->first();
        $this->request->session()->put('semester_id', $semester->nama);
        $this->request->session()->put('semester_aktif', $this->request->semester);
        $this->request->session()->put('sekolah_id', $event->user->sekolah_id);
        $this->request->session()->put('nama_sekolah', $event->user->sekolah->nama);
    }
}
