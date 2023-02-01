<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Layouts.pages.index');
    }

    public function show_all(){
        $pages = Page::all();
        if (request()->ajax()) {
            return DataTables::of($pages)
                ->addIndexColumn()
                ->editColumn('status', function ($page) {
                    $status_col=true;

                    return view('Layouts.pages.actions', compact('page','status_col'));
                })
                ->editColumn('action', function ($page) {
                    return view('Layouts.pages.actions', compact('page'));
                })
                ->rawColumns(['action', 'status'])
                ->toJson();
        }
        return view('layouts.pages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Layouts.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "title"    => "required",
            "slug"  => "required",
            "content"    => "required",
        ]);
        // try{
            $request['slug']=str_replace(" ","-",$request->slug);
            Page::create($request->except('_token'));
        // }catch(\Exception $e){

        // }

        return view('Layouts.pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page=Page::where('id',$id)->first();
        return view('Layouts.pages.show_content',compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page=Page::where('id',$id)->first();
        return view('Layouts.pages.create',compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page=Page::where('id',$id)->first();
        if(isset($request->title)){
            $page->update(['title'=>$request->title]);
        }
        if(isset($request->slug)){
            $request['slug']=str_replace(" ","-",$request->slug);
            $page->update(['slug'=>$request->slug]);
        }
        if(isset($request->meta_title)){
            $page->update(['meta_title'=>$request->meta_title]);
        }
        if(isset($request->status)){
            $page->update(['status'=>$request->status]);
        }
        if(isset($request->raw_meta)){
            $page->update(['raw_meta'=>$request->raw_meta]);
        }
        if(isset($request->content)){
            $page->update(['content'=>$request->content]);
        }
        return redirect()->route('pages.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function change_status(Request $request){
        $page = Page::where('id',$request->id)->first();
        if($page->status == "Active"){
            $page->update(['status'=>'In-active']);
        }else{
            $page->update(['status'=>'Active']);
        }
        return response()->json(array('msg'=> "success"), 200);
    }
}
