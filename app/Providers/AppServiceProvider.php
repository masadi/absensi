<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
//use App\Models\Setting;
//use Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        /*if (Schema::hasTable('settings')) {
            foreach (Setting::where('sekolah_id', 'e6ac05ed-6dad-488c-bf45-52c19afe73ee')->get() as $setting) {
                Config::set('settings.e6ac05ed-6dad-488c-bf45-52c19afe73ee.'.$setting->key, $setting->value);
            }
        }*/
    }
}
