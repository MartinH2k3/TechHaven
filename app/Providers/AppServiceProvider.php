<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('components.header', function ($view) {
            // Logic to fetch categories and products
            $categories = ['Mobily', 'Tablety', 'Notebooky', 'Herné Konzoly'];
            $categoriesWithProducts = [];

            foreach ($categories as $category) {
                $categoriesWithProducts[$category] = [
                    'recommended' => Product::where('category', $category)->orderByDesc('price')->take(3)->get(),
                    'newest' => Product::where('category', $category)->orderByDesc('created_at')->take(3)->get(),
                    'cheapest' => Product::where('category', $category)->orderBy('price')->take(3)->get(),
                ];
            }

            $view->with('categoriesWithProducts', $categoriesWithProducts);
        });
    }
}
