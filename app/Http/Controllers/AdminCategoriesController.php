<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class AdminCategoriesController extends Controller
{
    public function __construct ()
    {
        $this->middleware('auth:admin');
    }

    public function list()
    {
        $categories = Category::all();
        return view('admin.categories', ['categories' => $categories] );
    }

    public function delete($id, Request $request)
    {

        if (!$request->id || ($request->id != $id)) return back()->withErrors('Server Error... Please try again.');

        $category = Category::find($request->id);

        $category->delete();
        return redirect()->back()->with('message', 'Category '.$category->name.' was deleted!');
    }

    public function showEditForm($id=null)
    {
        $category = null;
        if ($id) $category = Category::find($id);

        return view('admin.edit-category', ['category'=> $category]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required | min:3 | max:30',
        ]);
        if ($request->id) {
            $category = Category::find($request->id);
            $message = 'Category '. $request->name .' was changed!';
        } else {
            $category = new Category;
            $message = 'Category '. $request->name .' was added!';
        }

        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();

        return redirect(url('admin/categories'))->with('message', $message);
    }
}
