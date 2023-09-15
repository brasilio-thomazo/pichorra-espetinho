<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductDataRequest;
use App\Http\Requests\UpdateProductDataRequest;
use App\Models\ProductData;

class ProductDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ProductData::with(['product'])->get();
        return response($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductDataRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductDataRequest $request)
    {
        $data = new ProductData($request->all());
        if (!$data->save()) {
            return response(['message' => 'Store product-data error'], 422);
        }

        $arr = $data->toArray();
        $arr['product'] = $data->product;

        return response($arr, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductData  $productData
     * @return \Illuminate\Http\Response
     */
    public function show(ProductData $productData)
    {
        $arr = $productData->toArray();
        $arr['product'] = $productData->product;
        return response($productData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductDataRequest  $request
     * @param  \App\Models\ProductData  $productData
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductDataRequest $request, ProductData $productData)
    {
        $fields = ['user_id', 'product_id', 'type', 'cost', 'price', 'profit', 'amount'];
        $data = [];
        foreach ($fields as $field) {
            if ($request->input($field) != $productData->$field) {
                $data[$field] = $request->input($field);
            }
        }

        if (!count($data)) {
            return response([], 204);
        }

        if (!$productData->update($data)) {
            return response(['message' => 'Update productData error', 'data' => $data], 422);
        }

        $arr = $productData->toArray();
        $arr['product'] = $productData->product;
        return response($arr);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductData  $productData
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductData $productData)
    {
        if (!$productData->delete()) {
            return response(['message' => 'Delete productData error'], 422);
        }
        return response([], 204);
    }
}
