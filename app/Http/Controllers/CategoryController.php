<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }

    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->validated());

        return CategoryResource::make($category);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category->load('books'));
    }

    public function update(
        CategoryUpdateRequest $request,
        Category $category
    ) {
        $category->update($request->validated());

        return CategoryResource::make($category);
    }

    public function destroy(Category $category)
    {
        // Small fix: a category with books can't be deleted (foreign key), so answer 409 instead of 500
        if ($category->books()->exists()) {
            return response()->json([
                'message' => 'This category has books and cannot be deleted'
            ], 409);
        }

        $category->delete();

        return response()->json([
            'message' => 'deleted'
        ]);
    }
}