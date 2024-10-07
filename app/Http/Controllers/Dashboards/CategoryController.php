<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where("user_id", auth()->id())->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {

        $data = $request->validated();
        $data['uuid'] = Str::uuid();
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['name']);

        $category = Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }
    public function show(Category $category)
    {
        $category = Category::where('slug', $category->slug)->firstOrFail();
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $category = Category::where('slug', $category->slug)->firstOrFail();
        return view('categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['name']);

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }


    public function destroy(Category $category)
    {
        $category = Category::where('slug', $category->slug)->firstOrFail();
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }



}

