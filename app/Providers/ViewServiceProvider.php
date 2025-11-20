<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Cabang;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('layouts.sidebar', function ($view) {
            $user = Auth::user();
            
            if (!$user) {
                $view->with('branches', collect());
                return;
            }

            // Get all cabangs and filter based on user permissions
            $branches = Cabang::all()->filter(function ($cabang) use ($user) {
                $permissionName = 'cabang_' . strtolower($cabang->kode_cabang);
                return $user->hasPermissionTo($permissionName);
            });

            $view->with('branches', $branches);
        });
    }
}