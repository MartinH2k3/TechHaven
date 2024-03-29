<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class BrowseController extends Controller
{
    public function index(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        // Start the query builder
        $query = Product::query();

        // Apply sort filter
        if ($request->has('sort')) {
            $sortOption = $request->input('sort');
            switch ($sortOption) {
                case 'price-asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price-desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'date-asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'date-desc':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        // Apply price range filter
        if ($request->filled(['price_from', 'price_to'])) {
            $query->whereBetween('price', [$request->input('price_from'), $request->input('price_to')]);
        }

        // Apply category filter
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        // Apply RAM filter
        if ($request->filled(['ram_from', 'ram_to'])) {
            $query->whereBetween('ram', [$request->input('ram_from'), $request->input('ram_to')]);
        }

        // Apply OS filter
        if ($request->filled('os')) {
            $osFilter = $request->input('os');
            $query->whereIn('operating_system', $osFilter); // Assumes 'operating_system' can be directly matched
        }

        // Apply display size filter
        if ($request->filled(['display_from', 'display_to'])) {
            $query->whereBetween('display_size', [$request->input('display_from'), $request->input('display_to')]);
        }

        // Pagination
        $products = $query->paginate(12);
        $products->appends($request->all());

        return view('browse', compact('products'));
    }
}

