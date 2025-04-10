<?php

namespace App\Providers;

use App\Models\dashboard\Setting;
use App\Models\dashboard\Resturant;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        View::composer('*', function ($view) {
            $route = Route::current();

            if (!$route)
                return;

            $restaurant = $route->parameter('restaurant');

            if ($restaurant instanceof Resturant) {
                // إذا كان Model Bound
                $view->with('restaurant', $restaurant);

                // إعدادات المطعم
                $setting = Setting::where('resturant_id', $restaurant->id)->first();
                if ($setting) {
                    $view->with('resturantsetting', $setting);
                }
            } elseif ($restaurant) {
                // إذا كان مجرد slug
                $restaurantModel = Resturant::where('slug', $restaurant)->first();

                if ($restaurantModel) {
                    $view->with('restaurant', $restaurantModel);

                    // إعدادات المطعم
                    $setting = Setting::where('resturant_id', $restaurantModel->id)->first();
                    if ($setting) {
                        $view->with('resturantsetting', $setting);
                    }
                } else {
                    // المطعم غير موجود - نجيب الإعدادات العامة
                    $defaultSetting = Setting::whereNull('resturant_id')->first();
                    if ($defaultSetting) {
                        $view->with('resturantsetting', $defaultSetting);
                    }
                }

            } else {
                // لا يوجد slug في الرابط - نعرض الإعدادات العامة
                $defaultSetting = Setting::whereNull('resturant_id')->first();
                if ($defaultSetting) {
                    $view->with('resturantsetting', $defaultSetting);
                }
            }
        });

        ///// Get Settings And Share

        view()->composer('dashboard.*', function () {
            if (!auth('admin')->check()) {
                $setting = Setting::where('resturant_id', null)->first();
            }
            if (Auth::guard('admin')->check()) {
                if (auth('admin')->user()->resturant_id == null) {
                    $setting = Setting::where('resturant_id', null)->first();
                } else {
                    $setting = Setting::where('resturant_id', auth('admin')->user()->resturant_id)->first();
                }
            }

            view()->share([
                'setting' => $setting
            ]);
        });

         // تشغيل الوظيفة فور تشغيل التطبيق (للاختبار فقط)
        // dispatch(new \App\Jobs\CheckInvoiceDeliveryJob);
        Paginator::useBootstrap();
        foreach (config('permissions') as $config_permission => $value) {
            Gate::define($config_permission, function ($auth) use ($config_permission) {
                return $auth->hasAccess($config_permission);
            });
        }
        // $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
        //     $schedule->job(new CheckInvoiceDeliveryJob)->everySecond();
        // });
    }
}
