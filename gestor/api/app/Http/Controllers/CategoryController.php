<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category($request->all());
        if (preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $request->image)) {
            $imgData = base64_decode($request->image);
            $imgFilename = sprintf("%s.png", md5($request->name));
            Storage::disk('public')->put($imgFilename, $imgData);
            $category->image = $imgFilename;
        }
        if (!$category->save()) {
            return response(['message' => 'Store category error'], 422);
        }
        return response($category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $arr = $category->toArray();
        $arr['subcategories'] = $category->subcategories;
        return response($arr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = [];
        if ($request->user_id != $category->user_id) {
            $data['user_id'] = $request->user_id;
        }
        if ($request->name != $category->name) {
            $data['name'] = $request->name;
        }
        if (preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $request->image)) {
            $imgData = base64_decode($request->image);
            $imgFilename = sprintf("%s.png", md5($request->name));
            Storage::disk('public')->put($imgFilename, $imgData);
            $data['image'] = $imgFilename;
        }
        if (!count($data)) {
            return response([], 204);
        }
        if (!$category->update($data)) {
            return response(['message' => 'Update category error'], 422);
        }
        return response($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->subcategories()->delete();
        if (!$category->delete()) {
            return response(['message' => 'Destroy category error'], 422);
        }
        return response([], 204);
    }
}
