<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeType;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AttributeController extends Controller
{
    public function index()
    {
        return view('Layouts.attributes.index');
    }

    public function attribute_data()
    {
        $attributes = Attribute::with('status', 'category', 'type')->get();
        if (request()->ajax()) {
            return DataTables::of($attributes)
                ->addIndexColumn()
                ->editColumn('category', function ($attributes) {
                    return isset($attributes->category->title) ? $attributes->category->title : "N/A";
                })
                ->editColumn('status', function ($attributes) {
                    return ($attributes->status->title == 'activated')? "<span class='badge badge-success'>" . ucfirst($attributes->status->title) . "</span>": "<span class='badge badge-warning'>" . ucfirst($attributes->status->title) . "</span>";
                })
                ->editColumn('type', function ($attributes) {
                    return isset($attributes->type->title) ? $attributes->type->title : "N/A";
                })
                ->editColumn('mandatory', function ($attributes) {
                    return $attributes->is_mandatory ? '<i class="fa-solid fa-check" style="color:green;"></i>' : '<i class="fa-solid fa-x" style="color:red;"></i>';
                })
                ->editColumn('actions', function ($attributes) {
                    return view('layouts.attributes.action', compact('attributes'));
                })
                ->rawColumns([ 'status', 'type','mandatory','actions'])
                ->toJson();
        }
        return view('layouts.attributes.index');
    }

    public function add_attribute_index()
    {
        $categories = Category::where('type_id',2)->get();
        $attribute_types = AttributeType::all();
        // $types = Type::all();
        return view('Layouts.attributes.add_attribute', compact('attribute_types', 'categories'));
    }

    public function add_attributes(Request $request)
    {
        $request['status_id'] = 8;
        $category = Attribute::create($request->except('_token'));
        return redirect()->route('attribute_group');
    }

    public function edit_attribute($id)
    {
        $categories = Category::where('type_id',2)->get();
        $attribute_types = AttributeType::all();
        $attribute = Attribute::where('id',$id)->first();
        return view('Layouts.attributes.add_attribute', compact('attribute_types', 'categories','attribute'));
    }

    public function Update_attribute($id,Request $request)
    {
        $attribute = Attribute::where('id',$id)->first();
        if(isset($request->title)){
            $attribute->update(['title'=>$attribute->title]);
        }
        if(isset($request->category_id)){
            $attribute->update(['category_id'=>$attribute->category_id]);
        }
        if(isset($request->value)){
            $attribute->update(['value'=>$attribute->value]);
        }
        if(isset($request->attribute_type_id)){
            $attribute->update(['attribute_type_id'=>$attribute->attribute_type_id]);
        }
        if(isset($request->is_mandatory)){
            $attribute->update(['is_mandatory'=>$attribute->is_mandatory]);
        }else{
            $attribute->update(['is_mandatory'=>0]);
        }
        return redirect()->route('attribute_group');
    }

    public function change_status(Request $request){
        $attribute = Attribute::where('id',$request->id)->first();
        if($attribute->status_id == 8){
            $attribute->update(['status_id'=>9]);
        }else{
            $attribute->update(['status_id'=>8]);
        }
        return response()->json(array('msg'=> "success"), 200);
    }

    public function delete($id)
    {
        $user = Attribute::where('id', $id)->delete();
        return "success";
    }
}
