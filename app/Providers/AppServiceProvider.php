<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
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
//        $perms=Permission::query()->get();
//
//        foreach ($perms as $perm) {
//            Gate::define($perm->name, function(User $user) use ($perm) {
//                return $user->roles()
//                    ->whereHas('permissions', fn(Builder $builder) => $builder->where('permissions.name', $perm->name))
//                    ->exists();
//            });
//        }

    }
}
