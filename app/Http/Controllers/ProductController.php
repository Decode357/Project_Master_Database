<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function productindex()
    {
        // $products = Product::all();
        // return view('product.index', compact('products'));
        return view('product');
    }
}
