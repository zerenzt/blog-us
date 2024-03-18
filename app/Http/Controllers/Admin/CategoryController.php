<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index ()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function store (Request $request)
    {
        // dd($request->all());

        //Validate the form
        $attr= $request->validate([
            'category_name' =>'required|string|unique:categories|max:250',
            'status' => 'required'
        ]);

        try {
            $data = Category::create($attr);
            if ($data){
                return to_route('category.index')->with('message', 'Category successfully');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
    // for ajax
    public function update (Request $request)
    {
        if ($request->ajax()) {
            $category = Category::find($request->id);
            if ($category) {
                return response()->json(['data' => $category], 200);
            }else{
                $errors = "Don't be sneaky!";
                return response()->json(['errors' => $errors], 200);
            }
}

        // Validate the form data
        $attr = $request->validate(rules: [
            'category_name' => 'required|string|max: 250 | unique:categories,id,'.$request->category_id,
            'status' => 'required'
        ]);
        //Sttore the form data into database
        try {
            $data = Category::findOrFail($request->category_id);
                if ($data) {
                    $data->update($attr);
                    return redirect()->route('category.index')->with('message', 'Category successfully updated!');
                }
        } catch (\Throwable $th) {
            throw $th;
        }

}
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index')->with('message', 'Category successfully deleted!');
    }

}