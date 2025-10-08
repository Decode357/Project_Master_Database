<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    ProductPrice, Product, User
};

class ProductPriceController extends Controller
{
    public function storeProductPrice(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'price'      => 'required|numeric|min:0',
            'currency'   => 'required|string|max:10',
            'price_tier' => 'nullable|string|max:50',
            'effective_date' => 'nullable|date',
        ]);

        $productPrice = ProductPrice::create([
            'product_id' => $data['product_id'],
            'price'      => $data['price'],
            'currency'   => $data['currency'],
            'price_tier' => $data['price_tier'] ?? null,
            'effective_date' => $data['effective_date'] ?? null,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return response()->json([
            'status'       => 'success',
            'message'      => 'Product Price created successfully!',
            'productPrice' => $productPrice
        ], 200);
    }
    public function productPriceIndex()
    {
        $productPrices = ProductPrice::with(['product', 'creator', 'updater'])
            ->orderBy('id', 'desc')
            ->paginate(10);
        $products = Product::all();
        $users = User::all();

        return view('product_price', compact('productPrices', 'products', 'users'));
    }

    public function destroyProductPrice(ProductPrice $productPrice)
    {
        $productPrice->delete();

        return redirect()->route('product-price.index')->with('success', 'Product Price deleted successfully.');
    }
}
