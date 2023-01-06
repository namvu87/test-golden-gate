<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function($query) {
            Log::info(
                $query->sql,
                $query->bindings,
                $query->time
            );
        });
        $this->autoloadRepository();
    }

    private function autoloadRepository()
    {
        $repoPath = app_path('Repositories');
        $repoDir = scandir($repoPath);

        foreach ($repoDir as $dir) {
            if (!in_array($dir, ['.', '..']) && is_dir($repoPath . "/$dir")) {
                \App::singleton(
                    "App\\Repositories\\" . $dir . "\\" . $dir . "Repository",
                    "App\\Repositories\\" . $dir . "\\" . $dir . "RepositoryEloquent"
                );
            }
        }
    }
}
