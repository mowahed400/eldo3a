<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    protected array $repos = [
        \App\Contracts\AdminContract::class     => \App\Repositories\AdminRepository::class,
        \App\Contracts\NotificationContract::class     => \App\Repositories\NotificationRepository::class,
        \App\Contracts\SectionContract::class     => \App\Repositories\SectionRepository::class,
        \App\Contracts\CategoryContract::class     => \App\Repositories\CategoryRepository::class,
        \App\Contracts\ContentContract::class     => \App\Repositories\ContentRepository::class,
        \App\Contracts\ParagraphContract::class     => \App\Repositories\ParagraphRepository::class,
        \App\Contracts\MarginContract::class     => \App\Repositories\MarginRepository::class,
        \App\Contracts\ContentMarginContract::class     => \App\Repositories\ContentMarginRepository::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->repos as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }
}
