<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with(['data', 'subcategory', 'subcategory.category'])->get();
        return response()->json($products, 200, [], JSON_NUMERIC_CHECK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $product = new Product($request->all());

        if (preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $request->image)) {
            $imgData = base64_decode($request->image);
            $imgFilename = sprintf("%s.png", md5($request->name . $request->subcategory_id));
            Storage::disk('public')->put($imgFilename, $imgData);
            $product->image = $imgFilename;
        }

        if (!$product->save()) {
            return response(['message' => 'Store subcategory error'], 422);
        }

        $arr = $product->toArray();
        $arr['data'] = $product->data;
        $arr['subcategory'] = $product->subcategory;
        $arr['subcategory']['category'] = $product->subcategory->category;

        return response($arr, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $arr = $product->toArray();
        $arr['data'] = $product->data;
        $arr['subcategory'] = $product->subcategory;
        $arr['subcategory']['category'] = $product->subcategory->category;
        return response($arr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $fields = ['user_id', 'subcategory_id', 'name', 'description'];
        $data = [];
        foreach ($fields as $field) {
            if ($request->input($field) != $product->$field) {
                $data[$field] = $request->input($field);
            }
        }

        if (preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $request->image)) {
            $imgData = base64_decode($request->image);
            $imgFilename = sprintf("%s.png", md5($request->name . $request->subcategory_id));
            Storage::disk('public')->put($imgFilename, $imgData);
            $data['image'] = $imgFilename;
        }

        if (!count($data)) {
            return response([], 204);
        }
        if (!$product->update($data)) {
            return response(['message' => 'Update product error'], 422);
        }

        $arr = $product->toArray();
        $arr['data'] = $product->data;
        $arr['subcategory'] = $product->subcategory;
        $arr['subcategory']['category'] = $product->subcategory->category;
        return response($arr);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->data()->delete();
        if (!$product->delete()) {
            return response(['message' => 'Delete product error'], 422);
        }
        return response([], 204);
    }

    public function list(Subcategory $subcategory)
    {
        $list = Product::with(['data'])->where('subcategory_id', '=', $subcategory->id)->get();
        return response($list);
    }
}
