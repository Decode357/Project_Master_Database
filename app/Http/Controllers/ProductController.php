<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Product, Status, ProductCategory,
    Shape, Glaze, Pattern, Backstamp,
    User, Image
};
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function productindex()
    {
        $relations = [
            'status', 'category', 'shape', 'glaze', 'pattern',
            'glaze.status', 'glaze.glazeOuter', 'glaze.glazeInside',
            'glaze.effect', 'glaze.effect.colors',
            'glaze.glazeInside.colors', 'glaze.glazeOuter.colors',
            'backstamp', 'creator', 'updater', 'image',
        ];

        $products = Product::with($relations)->latest()->paginate(10);

        $data = [
            'statuses'   => Status::all(),
            'categories' => ProductCategory::all(),
            'shapes'     => Shape::all(),
            'glazes'     => Glaze::all(),
            'patterns'   => Pattern::all(),
            'backstamps' => Backstamp::all(),
            'users'      => User::all(),
            'images'     => Image::all(),
        ];

        return view('product', array_merge($data, compact('products')));
    }

    private function rules($id = null)
    {
        return [
            'product_sku'  => [
                'required', 'string', 'max:255',
                Rule::unique('products', 'product_sku')->ignore($id),
            ],
            'product_name' => 'required|string|max:255',
            'status_id'    => 'nullable|exists:statuses,id',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'shape_id'     => 'nullable|exists:shapes,id',
            'glaze_id'     => 'nullable|exists:glazes,id',
            'pattern_id'   => 'nullable|exists:patterns,id',
            'backstamp_id' => 'nullable|exists:backstamps,id',
            'image_id'     => 'nullable|exists:images,id',
        ];
    }

    public function storeProduct(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['created_by'] = $data['updated_by'] = auth()->id();

        $product = Product::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Product created successfully.',
            'product' => $product,
        ], 201);
    }

    public function updateProduct(Request $request, Product $product)
    {
        $data = $request->validate($this->rules($product->id));
        $data['updated_by'] = auth()->id();

        $product->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Product updated successfully.',
            'product' => $product,
        ],200);
    }

    public function destroyProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully.',200);
    }
}
