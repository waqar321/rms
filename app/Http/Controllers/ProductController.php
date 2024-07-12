<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        // $products = Product::latest()->get();
        // return view('products.productInlineEditing', compact('products'));
        return view('products.productInlineEditing');
    }

    // public function index()
    // {
    //     $products = Product::latest()->get();

    //     return view('products.index', compact('products'));
    // }

    // public function create()
    // {
    //     return view('products.create');
    // }

    // public function edit(Product $product)
    // {
    //     return view('products.edit', compact('product'));
    // }
}