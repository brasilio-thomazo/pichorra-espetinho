<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubcategoryRequest;
use App\Http\Requests\UpdateSubcategoryRequest;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Storage;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Subcategory::with('category')->get();
        return response($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubcategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubcategoryRequest $request)
    {
        $subcategory = new Subcategory($request->all());
        if (preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $request->image)) {
            $imgData = base64_decode($request->image);
            $imgFilename = sprintf("%s.png", md5($request->name . $request->category_id));
            Storage::disk('public')->put($imgFilename, $imgData);
            $subcategory->image = $imgFilename;
        }
        if (!$subcategory->save()) {
            return response(['message' => 'Store subcategory error'], 422);
        }
        $arr = $subcategory->toArray();
        $arr['category'] = $subcategory->category;

        return response($arr, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        $arr = $subcategory->toArray();
        $arr['category'] = $subcategory->category;
        return response($arr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubcategoryRequest  $request
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubcategoryRequest $request, Subcategory $subcategory)
    {
        $fields = ['user_id', 'category_id', 'name'];
        $data = [];
        foreach ($fields as $field) {
            if ($request->input($field) != $subcategory->$field) {
                $data[$field] = $request->input($field);
            }
        }

        if (preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $request->image)) {
            $imgData = base64_decode($request->image);
            $imgFilename = sprintf("%s.png", md5($request->name . $request->category_id));
            Storage::disk('public')->put($imgFilename, $imgData);
            $data['image'] = $imgFilename;
        }

        if (!count($data)) {
            return response([], 204);
        }
        if (!$subcategory->update($data)) {
            return response(['message' => 'Update subcategory error'], 422);
        }

        $arr = $subcategory->toArray();
        $arr['category'] = $subcategory->category;
        return response($arr);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->products()->delete();
        $subcategory->delete();
        return response([], 204);
    }
}
