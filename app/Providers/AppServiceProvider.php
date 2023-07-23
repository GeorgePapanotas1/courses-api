<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Course\Repositories\Contracts\ICourseRepository;
use Modules\Course\Repositories\Eloquent\CourseRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ICourseRepository::class, CourseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
