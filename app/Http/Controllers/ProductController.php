<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Image;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Other methods...

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_name' => 'required|max:62',
            'product_description' => 'required',
            'operating_system' => 'required|max:40',
            'category' => 'required|max:40',
            'ram' => 'required|integer|min:0|max:999',
            'display_size' => 'required|numeric|min:0|max:999.9',
            'price' => 'required|numeric|min:0|max:9999.99',
            'product_image' => 'required|array',
            'product_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:8192',
        ]);

        $product = new Product([
            'id' => Str::uuid(),
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'operating_system' => $request->operating_system,
            'category' => $request->category,
            'ram' => $request->ram,
            'display_size' => $request->display_size,
            'price' => $request->price,
        ]);

        $product->save();

        if ($request->hasfile('product_image')) {
            foreach ($request->file('product_image') as $image) {
                // Generate a random filename with the correct extension
                $filename = Str::random(40) . '.' . $image->extension();

                // Store the image in the public disk under 'product_images' directory
                $path = $image->storeAs('images/product-images', $filename, 'public');

                $imageModel = new Image([
                    'product_id' => $product->id,
                    'filename' => $filename,
                ]);

                $imageModel->save();
            }
        }

        return redirect()->route('admin-page')->with('success', 'Product added successfully.');
    }


    public function show($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $product = Product::with('images')->findOrFail($id);

        return view('product-page', compact('product'));
    }
}
