<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Image;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Other methods...

    public function uploadProductImage(Request $request): void
    {
        $request->validate(['image' => 'required|image']);

        $image = $request->file('image');
        $hashedName = Str::random(40) . '.' . $image->getClientOriginalExtension();

        // Move the file to the 'storage/app/public/product-images' directory and create a symlink for public access
        $image->storeAs('public/product-images', $hashedName);

        $product = Product::findOrFail($request->product_id); // Use findOrFail to handle cases where the product doesn't exist
        $product->images()->create(['filename' => $hashedName]);

        // Redirect or return response...
    }

    public function show($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $product = Product::with('images')->findOrFail($id);

        return view('product-page', compact('product'));
    }
}
