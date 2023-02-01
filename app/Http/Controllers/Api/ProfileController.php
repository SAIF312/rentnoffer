<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function my_profile(Request $request){


        return response()->json([
            'status'=>200,
            'message'=>'profile loadeded successfully!',
            'profile'=>auth()->user()
        ]);
    }

    public function update_profile(Request $request){
        if($request->hasFile('profile_img')){

            $old_image = null;
            if(isset(auth()->user()->profile_img)){
                $old_image = auth()->user()->profile_img;
            }

            $file      = $request->file('profile_img');
            $file_path = Storage::put('public/profile', $file);
            $file_path = str_replace("public","storage",$file_path);
            $flag = auth()->user()->update(['profile_img' => $file_path]);
            if($flag){
                file_exists(public_path().'/'.$old_image) ? unlink(public_path().'/'.$old_image):'';
            }
        }
        if($request->hasFile('cover_img')){

            $old_image = null;
            if(isset(auth()->user()->cover_img)){
                $old_image = auth()->user()->cover_img;
            }

            $file      = $request->file('cover_img');
            $file_path = Storage::put('public/cover', $file);
            $file_path = str_replace("public","storage",$file_path);
            $flag = auth()->user()->update(['cover_img' => $file_path]);
            if($flag){
                file_exists(public_path().'/'.$old_image) ? unlink(public_path().'/'.$old_image):'';
            }
        }


        if(isset($request->first_name)){
            auth()->user()->update(['first_name'=>$request->first_name, 'full_name'=> $request->first_name.' '.auth()->user()->last_name]);
        }

        if(isset($request->last_name)){
            auth()->user()->update(['last_name'=>$request->last_name, 'full_name'=> auth()->user()->first_name.' '.$request->last_name]);
        }
        if(isset($request->bio)){
            auth()->user()->update(['bio'=>$request->bio]);
        }

        return response()->json([
            'status'=>200,
            'message'=>'profile updated successfully!'
        ]);
    }

    public function switch_profile(Request $request){
        if($request->is_lender == 0){
            auth()->user()->update(['is_lender'=>$request->is_lender]);
            return response()->json([
                'status'=>200,
                'message'=>'switched to borrower successfully!'
            ]);
        }else if($request->is_lender == 1){
            auth()->user()->update(['is_lender'=>$request->is_lender]);
            return response()->json([
                'status'=>200,
                'message'=>'switched to lender successfully!'
            ]);
        }else{
            return response()->json([
                'status'=>403,
                'message'=>'insert 1 or 0 only!'
            ]);
        }
    }

    public function favourites(){
        if(count(auth()->user()->favourites)){
            return response()->json([
                "status"=>200,
                "message"=>"fetch favourite products successfully!",
                "products"=>auth()->user()->favourites
            ]);
        }else{
            return response()->json([
                "status"=>404,
                "message"=>"don't have any favourite!",
            ],404);
        }
    }

    public function wishlist(){
        if(count(auth()->user()->wishlist)){
            return response()->json([
                "status"=>200,
                "message"=>"fetch wishlist successfully!",
                "products"=>auth()->user()->wishlist
            ]);
        }else{
            return response()->json([
                "status"=>404,
                "message"=>"don't have any wishlist!",
            ],404);
        }

    }
}
