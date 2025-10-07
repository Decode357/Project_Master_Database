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

    public function destroyProduct(Product $product)
    {
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
    }
}
