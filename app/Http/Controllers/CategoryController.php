<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        // dd($categories);

        return view('admin.category.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $data)
    {
        $data->validate([
            'name' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        // Mass assigment
        $result = Category::create($data->all());

        if ($result) {
            return redirect('admin/category')->with('success', 'Add data success!');
        } else {
            return redirect('admin/category')->with('failed', 'Add data failed!');
        }

        // $validator = Validator::make($data->all(), [
        //     'name' => 'required',
        //     'status' => 'required',
        // ], [
        //     'name.required' => 'Nama tidak boleh kosong.',
        // ]);

        // if ($validator->fails())
        // {
        //     // return redirect('admin/category/create');
        //     return redirect()
        //         ->back()
        //         ->withErrors($validator->errors())
        //         ->withInput($data->all());
        // } else {

        //     // simpan data
        //     $category = new Category();

        //     $category->name = $data->input('name');
        //     $category->status = $data->input('status');
        //     $result = $category->save();

        //     if ($result) {
        //         return redirect('admin/category')->with('success', 'Add data success!');
        //     } else {
        //         return redirect('admin/category')->with('failed', 'Add data failed!');
        //     }
        // }
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        // $category = Category::find($id);
        // $category = Category::where('id', $id)
            // ->get();
            // ->first();

        return view('admin.category.show', ['category' => $category]);
    }

    // Route model binding
    public function edit(Category $kategori)
    {
        return view('admin.category.edit', ['category' => $kategori]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        // $category->name = $request->input('name');
        // $category->status = $request->input('status');
        // $result = $category->save();

        // Mass assignment
        $result = $category->update($request->all());

        if ($result) {
            return redirect('admin/category')->with('success', 'Update data success!');
        } else {
            return redirect('admin/category')->with('failed', 'Update data failed!');
        }
    }

    public function destroy(Category $category)
    {
        $result = $category->delete();

        if ($result) {
            return redirect('admin/category')->with('success', 'Delete data success!');
        } else {
            return redirect('admin/category')->with('failed', 'Delete data failed!');
        }
    }
}
