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

        return view('customer.product-page', compact('product'));
    }

    /**
     * Search for products.
     *
     * This method is responsible for handling the search functionality in admin.
     * It starts a query builder on the Product model, applies a search filter if a search term is provided in the request,
     * gets the results, and returns a view with the products that match the search term.
     *
     * @param Request $request The request object containing the search term.
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application The search view with the products that match the search term.
     */
    public function search(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        // Start the query builder
        $products = Product::query();
        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->input('search');
            $products->where('product_name', 'LIKE', '%' . $searchTerm . '%');
            error_log($products->count());

        }

        // Get the results
        $products = $products->get();
        return view('admin.search', compact('products'));
    }

    /**
     * Show the manage page for a specific product.
     *
     * This method is responsible for storing the product ID in the session and
     * returning the manage view for the admin.
     *
     * @param mixed $id The ID of the product to manage.
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application The manage view.
     */
    public function showManage($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        session()->put('product_id', $id);
        return view('admin.manage');
    }

    /**
     * Manage a product.
     *
     * This method is responsible for handling the management of a product. It can
     * update the product or delete it based on the action specified in the request.
     * It deletes the product images from storage and the database if the product is deleted.
     *
     * @param Request $request The request object containing the data to manage the product.
     * @return RedirectResponse A redirect response to the search page with a success or error message.
     */
    public function manage(Request $request): RedirectResponse
    {
        // Get the product ID from the session
        $id = session()->get('product_id');

        // Update the product
        if ($request->input('action') == 'change') {
            // Validate the request data
            $validatedData = $request->validate([
                'product_name' => 'nullable|string|max:62',
                'product_description' => 'nullable|string',
                'operating_system' => 'nullable|string|max:40',
                'category' => 'nullable|string|max:40',
                'ram' => 'nullable|integer|min:0|max:999',
                'display_size' => 'nullable|numeric|min:0|max:999.9',
                'price' => 'nullable|numeric|min:0|max:9999.99',
                'product_image' => 'nullable|array',
                'product_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:8192',
            ]);

            // Remove null fields
            $validatedData = array_filter($validatedData, function ($value) {
                return !is_null($value);
            });
            // Remove product_image from the validated data
            unset($validatedData['product_image']);

            // Update the product
            Product::where('id', $id)->update($validatedData);

            // Update the product images
            if ($request->hasfile('product_image')) {
                foreach ($request->file('product_image') as $image) {
                    // Generate a random filename with the correct extension
                    $filename = Str::random(40) . '.' . $image->extension();

                    // Store the image in the public disk under 'product_images' directory
                    $path = $image->storeAs('images/product-images', $filename, 'public');

                    $imageModel = new Image([
                        'product_id' => $id,
                        'filename' => $filename,
                    ]);

                    $imageModel->save();
                }
            }

            return redirect()->route('admin.search')->with('success', 'Produkt bol upravený.');
        }
        // Delete the product
        else if ($request->input('action') == 'remove') {
            // Get all images of the product
            $images = Image::where('product_id', $id)->get();

            // Delete each image file from storage
            foreach ($images as $image) {
                Storage::disk('public')->delete('images/product-images/' . $image->filename);
            }

            // Delete image records from database
            Image::where('product_id', $id)->delete();

            // Delete the product
            Product::where('id', $id)->delete();
            return redirect()->route('admin.search')->with('success', 'Produkt bol vymazaný.');
        }

        return redirect()->route('admin.search')->with('error', 'Niečo sa pokazilo. Skúste to znova.');
    }
}
