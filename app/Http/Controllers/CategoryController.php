<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function getCategoryView()
    {
        $categories = Category::where('user_id', Auth::user()->id)->get();
        return view('category')->with(['categories' => $categories]);
    }

    public function getAddCategoryView()
    {
        return view('add-category');
    }

    public function saveCategory(Request $request)
    {
        $category = new Category();
        $category->user_id = Auth::user()->id;
        $category->name = $request->name;
        $result = $category->save();
        if ($result == true) {
            return redirect('category')->with('message', "Category Saved Successfully");
        } else {
            return redirect()->back()->with('message', $result);
        }
    }

    public function saveEditedCategory(Request $request)
    {
        $category = Category::where('id', $request->categoryId)->first();
        $category->name = $request->name;
        $result = $category->update();
        if ($result == true) {
            return redirect('category')->with('message', "Category updated Successfully");
        } else {
            return redirect()->back()->with('message', $result);
        }
    }

    public function deleteCategory($categoryId)
    {
        Category::where('id', $categoryId)->delete();
        return redirect()->back();
    }

    public function editCategory($categoryId)
    {
        $categories = Category::where('id', $categoryId)->first();
        return view('edit-category')->with(['categories' => $categories]);
    }
}
