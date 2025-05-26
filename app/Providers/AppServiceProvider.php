<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
<<<<<<< HEAD
        if(config('app.env') === 'production') {
            $this->app['request']->server->set('HTTPS', true); 
    }
=======
        if (config('app.env') === 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }
>>>>>>> f043413e96dff10a484af5c1bd04799264b4260b
        $this->app->bind('path.public', function () {
            return realpath(base_path() . '/../public_html');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return 'https://tokasafe.archimining.com/reset-password/' . $token;
        });
    }
}
