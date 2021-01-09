<?php

namespace App\Providers;

use App\Utils\SSR;
use Illuminate\Support\ServiceProvider;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class SSRServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SSR::class, function($app) {
            return new SSR();
        });
    }
}
