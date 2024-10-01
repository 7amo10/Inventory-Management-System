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
        $categories = Category::where("user_id", auth()->id())->count();

        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {

    }

    public function store(StoreCategoryRequest $request)
    {

    }

    public function show(Category $category)
    {

    }

    public function edit(Category $category)
    {

    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {

    }

    public function destroy(Category $category)
    {

    }
}
