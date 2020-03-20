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

        AdminModule::create('timeshift')
            ->title('Timeshift')
            ->summary('Preview your store at a different date and time')
            ->routes(dirname(__DIR__).'/routes.php')
            ->route('admin.modules.timeshift.index');
    }
}
