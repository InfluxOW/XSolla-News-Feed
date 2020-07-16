<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\NewsResource;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        return CategoriesResource::collection(Category::all());
    }

    public function show(Category $category)
    {
        return NewsResource::collection($category->news);
    }
}
