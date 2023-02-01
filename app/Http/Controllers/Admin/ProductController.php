<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function active_index()
    {
        return view('layouts.products.active');
    }

    public function disabled_index()
    {
        return view('layouts.products.deactivate');
    }

    public function rejected_index()
    {
        return view('layouts.products.rejected');
    }
    public function pending_index()
    {
        return view('layouts.products.pending');
    }

    public function add_category_index()
    {
        // $products = Product::all();
        // $types = Type::all();
        return view('Layouts.products.add_category', compact('products', 'types'));
    }
    public function add_category(Request $request)
    {

        $request['status_id'] = 3;

        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $file_path = Storage::put('public/category', $file);
            $request['featured_image'] = str_replace("public", "storage", $file_path);
        }
        $category = Product::create($request->except('MAX_FILE_SIZE', 'image'));
        return redirect()->route('products');
    }
    public function approved()
    {
        $products = Product::with('type', 'status', 'user', 'category', 'address')->where('status_id', '8')->get();
        if (request()->ajax()) {
            return DataTables::of($products)
                ->addIndexColumn()
                ->editColumn('name', function ($products) {
                    return ucwords($products->name);
                })
                ->editColumn('status', function ($products) {
                    return "<span class='badge badge-success'>" . ucfirst($products->status->title) . "</span>";
                })
                ->editColumn('type', function ($products) {
                    return ($products->type->title == 'Item')? "<span class='badge badge-primary'>" . ucfirst($products->type->title) . "</span>": "<span class='badge badge-success'>" . ucfirst($products->type->title) . "</span>";
                })
                ->editColumn('image', function ($products) {
                    return view('Layouts.products.image', compact('products'));
                })
                ->editColumn('category', function ($products) {
                    return isset($products->category) ? ucwords($products->category->title) : "N/A";
                })
                ->editColumn('user', function ($products) {
                    return isset($products->user) ? ucwords($products->user->username) : "N/A";
                })
                ->editColumn('actions', function ($products) {
                    return view('Layouts.products.actions', compact('products'));
                })
                ->rawColumns(['actions', 'status', 'image', 'type'])
                ->toJson();
        }
        return view('layouts.products.index');
    }
    public function deactivate()
    {
        $products = Product::with('type', 'status', 'user', 'category', 'address')->where('status_id', '9')->get();
        if (request()->ajax()) {
            return DataTables::of($products)
                ->addIndexColumn()
                ->editColumn('name', function ($products) {
                    return ucwords($products->name);
                })
                ->editColumn('status', function ($products) {
                    return "<span class='badge badge-warning'>" . ucfirst($products->status->title) . "</span>";
                })
                ->editColumn('type', function ($products) {
                    return ($products->type->title == 'Item')? "<span class='badge badge-primary'>" . ucfirst($products->type->title) . "</span>": "<span class='badge badge-success'>" . ucfirst($products->type->title) . "</span>";
                })
                ->editColumn('image', function ($products) {
                    return view('Layouts.products.image', compact('products'));
                })
                ->editColumn('category', function ($products) {
                    return isset($products->category) ? ucwords($products->category->title) : "N/A";
                })
                ->editColumn('user', function ($products) {
                    return isset($products->user) ? ucwords($products->user->username) : "N/A";
                })
                ->editColumn('actions', function ($products) {
                    return view('Layouts.products.actions', compact('products'));
                })
                ->rawColumns(['actions', 'status', 'image', 'type'])
                ->toJson();
        }
        return view('layouts.products.index');
    }
    public function rejected()
    {
        $products = Product::with('type', 'status', 'user', 'category', 'address')->where('status_id', '2')->get();
        if (request()->ajax()) {
            return DataTables::of($products)
                ->addIndexColumn()
                ->editColumn('name', function ($products) {
                    return ucwords($products->name);
                })
                ->editColumn('status', function ($products) {
                    return "<span class='badge badge-danger'>" . ucfirst($products->status->title) . "</span>";
                })
                ->editColumn('type', function ($products) {
                    return ($products->type->title == 'Item')? "<span class='badge badge-primary'>" . ucfirst($products->type->title) . "</span>": "<span class='badge badge-success'>" . ucfirst($products->type->title) . "</span>";
                })
                ->editColumn('image', function ($products) {
                    return view('Layouts.products.image', compact('products'));
                })
                ->editColumn('category', function ($products) {
                    return isset($products->category) ? ucwords($products->category->title) : "N/A";
                })
                ->editColumn('user', function ($products) {
                    return isset($products->user) ? ucwords($products->user->username) : "N/A";
                })
                ->editColumn('actions', function ($products) {
                    return view('Layouts.products.actions', compact('products'));
                })
                ->rawColumns(['actions', 'status', 'image', 'type'])
                ->toJson();
        }
        return view('layouts.products.index');
    }
    public function pending()
    {
        $products = Product::with('type', 'status', 'user', 'category', 'address')->where('status_id', 1)->get();
        if (request()->ajax()) {
            return DataTables::of($products)
                ->addIndexColumn()
                ->editColumn('name', function ($products) {
                    return ucwords($products->name);
                })
                ->editColumn('status', function ($products) {
                    return "<span class='badge badge-primary'>" . ucfirst($products->status->title) . "</span>";
                })
                ->editColumn('type', function ($products) {
                    return ($products->type->title == 'Item')? "<span class='badge badge-primary'>" . ucfirst($products->type->title) . "</span>": "<span class='badge badge-success'>" . ucfirst($products->type->title) . "</span>";
                })
                ->editColumn('image', function ($products) {
                    return view('Layouts.products.image', compact('products'));
                })
                ->editColumn('category', function ($products) {
                    return isset($products->category) ? ucwords($products->category->title) : "N/A";
                })
                ->editColumn('user', function ($products) {
                    return isset($products->user) ? ucwords($products->user->username) : "N/A";
                })
                ->editColumn('actions', function ($products) {
                    return view('Layouts.products.actions', compact('products'));
                })
                ->rawColumns(['actions', 'status', 'image', 'type'])
                ->toJson();
        }
        return view('layouts.products.index');
    }
    public function disable($id)
    {
        $user = Product::where('id', $id)->update(['status_id' => 9]);
        return "success";
    }
    public function delete($id)
    {
        $user = Product::where('id', $id)->delete();
        return "success";
    }
    public function active($id)
    {
        $user = Product::where('id', $id)->update(['status_id' => 3]);
        return "success";
    }

    public function accept_product($id)
    {
        $user = Product::where('id', $id)->update(['status_id' => 8]);
        return "success";
    }

    public function reject_product($id)
    {
        $user = Product::where('id', $id)->update(['status_id' => 2]);
        return "success";
    }
}
