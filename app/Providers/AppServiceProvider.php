<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\UserNotification;
use Illuminate\Support\Facades\View;

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
    public function boot()
    {
        // Tambahkan kode view composer di sini
        View::composer('admin.layouts.sidebar', function ($view) {
            $notifikasiCount = UserNotification::where('receiver_role', 'admin')
                ->where('status', 'unread')
                ->count();
            $view->with('notifikasiCount', $notifikasiCount);
        });
    }
}
