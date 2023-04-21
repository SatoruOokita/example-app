<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Blade;

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
        Blade::directive('highlight', function ($expression) {
            list($search, $value) = explode(',', $expression);
            return "<?php echo !empty(trim($search)) ? preg_replace('/(' . preg_quote($search, '/') . ')/i', '<span class=\"bg-yellow-300\">$1</span>', e($value)) : e($value); ?>";
});
}
}