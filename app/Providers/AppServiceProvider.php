<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Course\Core\Repositories\Contracts\ICourseRepository;
use Modules\Course\Core\Repositories\Eloquent\CourseRepository;
use Modules\Course\Core\Services\Contracts\ICourseService;
use Modules\Course\Core\Services\Providers\CourseService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
