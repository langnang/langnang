<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;

/** @mixin \Illuminate\Database\Eloquent\Builder */
class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Builder::macro('active', function () {
            return $this->where('status', 1);
        });
    }
}
