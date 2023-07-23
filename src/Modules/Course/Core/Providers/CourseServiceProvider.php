<?php

namespace Modules\Course\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Course\Core\Repositories\Contracts\ICourseRepository;
use Modules\Course\Core\Repositories\Eloquent\CourseRepository;
use Modules\Course\Core\Services\Contracts\ICourseService;
use Modules\Course\Core\Services\Providers\CourseService;

class CourseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ICourseRepository::class, CourseRepository::class);
        $this->app->bind(ICourseService::class, CourseService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
