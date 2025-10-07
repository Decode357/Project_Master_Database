<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    ProductPrice, Product, User
};

class ProductPriceController extends Controller
{
    public function productPriceIndex()
    {
        $productPrices = ProductPrice::with(['product', 'creator', 'updater'])
            ->orderBy('id', 'desc')
            ->paginate(10);
        $product = Product::all();
        $users = User::all();

        return view('product_price', compact('productPrices', 'product', 'users'));
    }
}
