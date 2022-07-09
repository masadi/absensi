<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $text_class = ['class' => 'd-flex align-items-center'];
        \Menu::make('MyNavBar', function ($menu) use ($text_class, $request){
            $menu->add('Beranda')->data('role', ['administrator', 'ptk', 'pd'])->append('</span>')->prepend($this->icon('home'))->link->attr($text_class);
            //$menu->add('Pengaturan', 'pengaturan')->data('role', ['administrator'])->append('</span>')->prepend($this->icon('settings'))->link->attr($text_class);
            $menu->add('Sekolah', 'data-sekolah')->data('role', ['administrator'])->append('</span>')->prepend($this->icon('server'))->link->attr($text_class);
            $menu->add('PTK', 'ptk')->data('role', ['administrator'])->append('</span>')->prepend($this->icon('users'))->link->attr($text_class);
            $menu->add('Proses Absensi', 'absensi')->data('role', ['ptk', 'pd'])->append('</span>')->prepend($this->icon('user-check'))->link->attr($text_class);
            $menu->add('Rekapitulasi', 'rekapitulasi')->data('role', ['administrator', 'ptk', 'pd'])->append('</span>')->prepend($this->icon('list'))->link->attr($text_class);
            $menu->add('Pengaturan', 'javascript:void(0)')->data('role', ['administrator'])->append('</span>')->prepend($this->icon('mail'))->link->attr($text_class);
            $menu->pengaturan->add('Kategori', 'setting/kategori')->data('role', ['administrator'])->append('</span>')->prepend($this->icon('circle'))->link->attr($text_class);
            $menu->pengaturan->add('Jam', 'setting/jam')->data('role', ['administrator'])->append('</span>')->prepend($this->icon('circle'))->link->attr($text_class);
            //$menu->pageLayouts->add('Without Menu', 'layouts/without-menu')->data('role', ['administrator'])->append('</span>')->prepend($this->icon('circle'))->link->attr($text_class);
            //$menu->pageLayouts->add('Layout Empty', 'layouts/empty')->data('role', ['administrator'])->append('</span>')->prepend($this->icon('circle'))->link->attr($text_class);
            //$menu->pageLayouts->add('Layout Blank', 'layouts/blank')->data('role', ['administrator'])->append('</span>')->prepend($this->icon('circle'))->link->attr($text_class);
            $menu->add('Profile', 'user/profile')->data('role', ['administrator', 'ptk', 'pd'])->append('</span>')->prepend($this->icon('user'))->link->attr($text_class);
            $menu->add('Keluar Aplikasi', 'logout')->data('role', ['administrator', 'ptk', 'pd'])->append('</span>')->prepend($this->icon('power'))->link->attr([
                'class'         => 'd-flex align-items-center text-danger',
                'onclick'   => 'event.preventDefault(); document.getElementById(\'logout-form\').submit();',
            ]);
            /*
            <a class="dropdown-item" href="http://absensi.test/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-power me-50"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path><line x1="12" y1="2" x2="12" y2="12"></line></svg> Logout
          </a>
            */
        })->filter(function($item) use ($request){
            $user = auth()->user();
            $semester = $request->session()->get('semester_id');
            if($user && $user->hasRole( $item->data('role'), $semester)) {
                return true;
            }
            return false;
        });
        return $next($request);
    }
    public function icon($icon){
        return '<i data-feather="'.$icon.'"></i><span class="menu-title text-truncate">';
    }
}
