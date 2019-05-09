<?php

namespace GeekDC\Sensitive;

use Illuminate\Support\ServiceProvider;

class LaravelSensitiveProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // 单例绑定服务
        $this->app->singleton('sensitive', function ($app) {
            return $this->app->make('GeekDC\Sensitive\SensitiveHandle');
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/sensitive.php' => config_path('sensitive.php'),
        ]);

        // 註冊中間件
        $this->app['router']->aliasMiddleware('sensitive', \GeekDC\Sensitive\Middleware\SensitiveFilter::class);

        // 數據表
        $this->loadMigrationsFrom(__DIR__.'/migrations/2019_05_08_000000_create_sensitive_table.php');
    }
}
