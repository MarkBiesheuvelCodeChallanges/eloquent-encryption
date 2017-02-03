<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Input;
use App\Models\Product;

class ProductController extends BaseController
{
    public function index()
    {
        if (Input::get('raw', false)) {
            $products = app('db')->select('SELECT * FROM products');
        } else {
            $products = Product::all();
        }

        return response()->json($products);
    }

    public function create()
    {
        $product = new Product();

        foreach (Input::all() as $key => $value) {
            $product->setAttribute($key, $value);
        }

        $product->save();

        return response()->json($product, 201);
    }

    public function read($id)
    {
        $product = Product::find($id);

        if ($product === null) {
            return response('', 404);
        }

        return response()->json($product);
    }

    public function update($id)
    {
        $product = Product::find($id);

        if ($product === null) {
            return response('', 404);
        }

        foreach (Input::all() as $key => $value) {
            $product->setAttribute($key, $value);
        }

        $product->save();

        return response()->json($product);
    }

    public function delete($id)
    {
        $product = Product::find($id);

        if ($product === null) {
            return response('', 404);
        }

        $product->delete();

        return response()->json(new \stdClass());
    }
}
