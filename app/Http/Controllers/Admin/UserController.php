<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\CreateUserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

        return view('Layouts.users.index');
    }
    public function user_data()
    {

        $users = User::whereHas('roles',function($q){
            $q->where('name', '!=','admin');
        })->where('phone_verification',1)->with('status', 'addressess', 'orders', 'products')->get();
        if (request()->ajax()) {

            return DataTables::of($users)
                ->addIndexColumn()
                ->editColumn('status', function ($users) {
                    if ($users->status->title == 'new' || $users->status->title == 'disable' || $users->status->title == 'blocked' || $users->status->title == 'pending'){
                        return "<span class='badge badge-warning'>" . ucfirst($users->status->title) . "</span>";
                    }else if ($users->status->title == 'deactivated'){
                        return "<span class='badge badge-danger'>" . ucfirst($users->status->title) . "</span>";
                    }else if ($users->status->title == 'activated'){
                        return "<span class='badge badge-success'>" . ucfirst($users->status->title) . "</span>";
                    }
                })
                ->editColumn('avatar', function ($users) {
                    if($users->profile_img != ''){
                        return "<img src='$users->profile_img' height='60px' width='60px'>";
                    }else{
                        return "<img src=".asset('assets/assets/img/90x90.jpg')." height='60px' width='60px'>";
                    }

                })
                ->editColumn('state', function ($users) {
                    return $users->primary_address? $users->primary_address->state->title:'N/A';
                })
                ->editColumn('products', function ($users) {
                    return count($users->products);
                })
                ->editColumn('orders', function ($users) {
                    return count($users->orders);
                })
                ->editColumn('actions', function ($users) {
                    return view('Layouts.users.actions', compact('users'));
                })
                ->rawColumns(['actions', 'status', 'avatar'])
                ->toJson();
        }
        return view('Layouts.users.index');
    }

    public function create(){
        $roles = Role::all();
        return view('Layouts.users.create',compact('roles'));
    }

    public function store(CreateUserRequest $request){
        // dd($request->all());

            // CreateUser



        $request['full_name'] = $request->first_name . ' ' . $request->last_name;
        $request['password'] = Hash::make($request->password);
        $user = User::create($request->except('password_confirmation','role_id'));
        if ($user) {
            $user->attachRole($request->role_id);
            $stripeCustomer = $user->createAsStripeCustomer();
        }
        return redirect()->route('users');
    }

    public function disable($id)
    {
        $user = User::where('id', $id)->update(['status_id' => 9]);
        return "success";
    }

    public function active($id)
    {
        $user = User::where('id', $id)->update(['status_id' => 8]);
        return "success";
    }

    public function block($id)
    {
        $user = User::where('id', $id)->update(['status_id' => 5]);
        return "success";
    }
}
