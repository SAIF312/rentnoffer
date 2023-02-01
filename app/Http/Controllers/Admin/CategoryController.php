<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        return view('Layouts.categories.index');
    }

    public function add_category_index()
    {
        $categories = Category::all();
        $types = Type::all();
        return view('Layouts.categories.add_category', compact('categories', 'types'));
    }
    public function add_category(Request $request)
    {

        $request['status_id'] = 1;

        if ($request->hasFile('image')) {
            // $old_image = null;
            // if (isset(auth()->user()->image)) {
            //     $old_image = auth()->user()->image;
            // }
            $file      = $request->file('image');
            $file_path = Storage::put('public/category', $file);
            $request['featured_image'] = str_replace("public", "storage", $file_path);
            // $flag = User::create(['image' => $file_path])->where();
            // if ($flag) {
            //     file_exists(public_path() . '/' . $old_image) ? unlink(public_path() . '/' . $old_image) : '';
            // }
        }
        $category = Category::create($request->except('MAX_FILE_SIZE', 'image'));
        return redirect()->route('categories');
    }
    public function edit_category($id){
        $category = Category::where('id',$id)->first();
        $categories = Category::all();
        $types = Type::all();
        return view('Layouts.categories.add_category', compact('categories', 'types','category'));
    }
    public function category_data()
    {
        $categories = Category::with('type', 'status')->get();
        if (request()->ajax()) {
            return DataTables::of($categories)
                ->addIndexColumn()
                ->editColumn('title', function ($categories) {
                    return ucfirst($categories->title);
                })
                ->editColumn('status', function ($categories) {
                    return ($categories->status->title == 'activated')? "<span class='badge badge-success'>" . ucfirst($categories->status->title) . "</span>": "<span class='badge badge-warning'>" . ucfirst($categories->status->title) . "</span>";
                })
                ->editColumn('type', function ($categories) {
                    return ($categories->type->title == 'Item')? "<span class='badge badge-primary'>" . ucfirst($categories->type->title) . "</span>": "<span class='badge badge-success'>" . ucfirst($categories->type->title) . "</span>";
                })
                ->editColumn('avatar', function ($categories) {
                    return view('Layouts.categories.featured_image', compact('categories'));
                })
                ->editColumn('parent', function ($categories) {
                    return isset($categories->parent_id)?ucfirst($categories->parent->title):'N/A';
                })
                ->editColumn('actions', function ($categories) {
                    return view('Layouts.categories.actions', compact('categories'));
                })
                ->rawColumns(['actions', 'status', 'avatar', 'type'])
                ->toJson();
        }
        return view('Layouts.categories.index');
    }
    public function disable($id)
    {
        $user = Category::where('id', $id)->update(['status_id' => 9]);
        return "success";
    }
    public function delete($id)
    {
        $user = Category::where('id', $id)->delete();
        return "success";
    }
    public function active($id)
    {
        $user = Category::where('id', $id)->update(['status_id' => 8]);
        return "success";
    }
}
