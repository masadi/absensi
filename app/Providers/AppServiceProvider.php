<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Tahun_pendataan;
use Config;
use App\Setting;
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
        if(Schema::hasTable('tahun_pendataan')){
            $tahun_pendataan = Tahun_pendataan::where('periode_aktif', 1)->first();
            Config::set('app.tahun_pendataan', ($tahun_pendataan) ? $tahun_pendataan->tahun_pendataan_id : NULL);
        };
        if (Schema::hasTable('settings')) {
            foreach (Setting::all() as $setting) {
                Config::set('setting.'.$setting->key, $setting->value);
            }
        }
    }
}
