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
        $relations = [
            'product', 'creator', 'updater'
        ];

        $productPrices = ProductPrice::with($relations)->latest()->paginate(10);

        $data = [
            'products' => Product::all(),
            'users'    => User::all(),
        ];

        return view('product_price', array_merge($data, compact('productPrices')));
    }

    private function rules()
    {
        return [
            'product_id'     => 'required|exists:products,id',
            'price'          => 'required|numeric|min:0',
            'currency'       => 'required|string|max:10',
            'price_tier'     => 'nullable|string|max:50',
            'effective_date' => 'nullable|date',
        ];
    }

    public function storeProductPrice(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['created_by'] = $data['updated_by'] = auth()->id();

        $productPrice = ProductPrice::create($data);

        return response()->json([
            'status'       => 'success',
            'message'      => 'Product Price created successfully!',
            'productPrice' => $productPrice
        ], 201);
    }

    public function updateProductPrice(Request $request, ProductPrice $productPrice)
    {
        $data = $request->validate($this->rules());
        $data['updated_by'] = auth()->id();

        $productPrice->update($data);

        return response()->json([
            'status'       => 'success',
            'message'      => 'Product Price updated successfully!',
            'productPrice' => $productPrice
        ], 200);
    }

    public function destroyProductPrice(ProductPrice $productPrice)
    {
        $productPrice->delete();
        return redirect()->route('product-price.index')->with('success', 'Product Price deleted successfully.',200);
    }
}
