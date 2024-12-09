<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('notes')->get();
        return CategoryResource::collection($categories);
    }

    public function indexByUser()
    {
        $user = auth()->user();
        $categories = Category::with('notes')->where('user_id', $user->id)->get();
        return CategoryResource::collection($categories);
    }

    public function store(CategoryRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();
        $data['user_id'] = $user->id;
        $category = Category::create($data);
        return new CategoryResource($category);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        $category->load('notes');
        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->validated());
        return new CategoryResource($category);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully.']);
    }
}
