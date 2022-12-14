<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Generalsetting;
use App\Blog;
use App\Sociallink;
use App\Seotool;
use App\Pagesetting;
use App\Language;
use App\Advertise;
use App\user_languages;
use Auth;
use App\how_it_works;
use App\reasons_to_book;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);

        view()->composer('*',function($settings){

            if (!empty($_SERVER['HTTP_CLIENT_IP']))
            {
                $ip_address = $_SERVER['HTTP_CLIENT_IP'];
            }

            //whether ip is from proxy
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            {
                $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }

            //whether ip is from remote address
            else
                {
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                }

            $language = user_languages::where('ip','=',$ip_address)->first();

            if($language == '')
            {
                $language = new user_languages;
                $language->ip = $ip_address;
                $language->lang = 'du';
                $language->save();
            }

            $user = Auth::guard('user')->user();

            if (Auth::check()) {
                $settings->with('currentUser', Auth::user());
            }else {
                $settings->with('currentUser', null);
            }

            if($settings->currentUser == '')
            {
                $settings->with('gs', Generalsetting::where('backend',0)->first());
            }
            else
                {
                    $settings->with('gs', Generalsetting::where('backend',1)->first());
                }

            $settings->with('sl', Sociallink::find(1));
            $settings->with('seo', Seotool::find(1));
            $settings->with('ps', Pagesetting::find(1));
            $settings->with('lang', Language::where('lang','=',$language->lang)->first());
            $settings->with('hiw', how_it_works::findOrFail(1));
            $settings->with('rtb', reasons_to_book::findOrFail(1));
            $settings->with('lblogs', Blog::orderBy('created_at', 'desc')->limit(4)->get());
            $settings->with('ad728x90', Advertise::inRandomOrder()->where('size','728x90')->where('status',1)->first());
            $settings->with('ad300x250', Advertise::inRandomOrder()->where('size','300x250')->where('status',1)->first());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
