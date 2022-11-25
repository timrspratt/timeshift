<?php

namespace Timrspratt\Timeshift;

use Aero\Admin\AdminModule;
use Aero\Common\Providers\ModuleServiceProvider;
use Aero\Common\Services\TimeMachine as BaseTimeMachine;
use Illuminate\Routing\Router;
use Timrspratt\Timeshift\Http\Middleware\DetectCookie;

class ServiceProvider extends ModuleServiceProvider
{
    public function boot(): void
    {
        $this->app->make(Router::class)
            ->pushMiddlewareToGroup('store', DetectCookie::class);

        $this->loadViewsFrom(dirname(__DIR__).'/resources/views', 'timeshift');
    }

    public function register(): void
    {
        $this->app->bind(BaseTimeMachine::class, TimeMachine::class);

        Router::addStoreRoutes(__DIR__.'/../routes/web.php');

        AdminModule::create('timeshift')
            ->title('Timeshift')
            ->summary('Preview your store at a different date and time')
            ->routes(dirname(__DIR__).'/routes/admin.php')
            ->route('admin.modules.timeshift.index');
    }
}
