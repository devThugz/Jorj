<?php

namespace App\Providers;

use App\Contracts\BookServiceInterface;
use App\Services\BookService;
use Illuminate\Support\ServiceProvider;

class BookServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(BookServiceInterface::class, BookService::class);
    }

    public function boot(): void
    {

    }
}
