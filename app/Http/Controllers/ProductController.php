<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Product, Status, ProductCategory, 
    Shape, Glaze, Pattern, Backstamp, 
    User, Image, GlazeOuter, GlazeInside, 
    Effect, Color
};

class ProductController extends Controller
{
    public function productindex()
    {
        $products = Product::with([
            'status', 'category', 'shape', 'glaze', 'pattern', 'glaze.status',
            'glaze.glazeOuter', 'glaze.glazeInside', 'glaze.effect',
            'glaze.effect.colors',
            'glaze.glazeInside.colors',
            'glaze.glazeOuter.colors',
            'backstamp', 'creator', 'updater', 'image',
            ])->orderBy('id', 'desc')->paginate(10);

        $statuses = Status::all();
        $categories = ProductCategory::all();
        $shapes = Shape::all();
        $glazes = Glaze::all();
        $patterns = Pattern::all();
        $backstamps = Backstamp::all();
        $users = User::all();
        $images = Image::all();

        return view('product', compact('products', 'statuses', 'categories', 'shapes', 'glazes', 
        'patterns', 'backstamps', 'users', 'images'));
    }

    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'product_sku'      => 'required|string|max:255|unique:products,product_sku',
            'product_name'     => 'required|string|max:255',
            'status_id'        => 'nullable|exists:statuses,id',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'shape_id'         => 'nullable|exists:shapes,id',
            'glaze_id'         => 'nullable|exists:glazes,id',
            'pattern_id'       => 'nullable|exists:patterns,id',
            'backstamp_id'     => 'nullable|exists:backstamps,id',
            'image_id'         => 'nullable|exists:images,id',
        ]);

        $product = Product::create([
            'product_sku'      => $data['product_sku'],
            'product_name'     => $data['product_name'],
            'status_id'        => $data['status_id'] ?? null,
            'product_category_id' => $data['product_category_id'] ?? null,
            'shape_id'         => $data['shape_id'] ?? null,
            'glaze_id'         => $data['glaze_id'] ?? null,
            'pattern_id'       => $data['pattern_id'] ?? null,
            'backstamp_id'     => $data['backstamp_id'] ?? null,
            'image_id'         => $data['image_id'] ?? null,
            'created_by'       => auth()->id(),
            'updated_by'       => auth()->id(),
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully.',
            'product' => $product
        ], 201);
    }


    public function destroyProduct(Product $product)
    {
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
    }
}
