<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\Address;
use App\Http\Requests\Api\AddressRequest;
class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses  = Address::where('user_id',auth()->id())->get();
        if(count($addresses)){
            return response()->json([
                "status"=>200,
                "message"=>'fetch addresses successfully!',
                "addresses"=>Address::where('user_id',auth()->id())->get()
            ],200);
        }else{
            return response()->json([
                "status"=>404,
                "message"=>'you do not have any address!',
            ],404);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressRequest $request)
    {
        if($request->is_primary){
            $addresses  = Address::where('user_id',auth()->id())->get();
            foreach($addresses as $address){
                $address->update(['is_primary'=>0]);
            }
        }else{
            if(!Address::where('user_id',auth()->id())->count()){
                $request['is_primary'] = 1;
            }
        }

        try{
            $request['user_id'] = auth()->id();
            $address = Address::create($request->all());
            return response()->json([
                "status"=>200,
                "message"=>'address added successfully!',
            ],200);
        }catch(\Exception $e){
            return response()->json([
                "status"=>500,
                "message"=>$e->getMessage(),
            ],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $address = Address::where('id',$id)->where('user_id',auth()->id())->first();
        if($address){
            return response()->json([
                "status"=>200,
                "message"=>'fetch address successfully!',
                "address"=>$address
            ],200);
        }else{
            return response()->json([
                "status"=>404,
                "message"=>'address not found! or not belongs to you',
            ],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $address = Address::where('id',$id)->where('user_id',auth()->id())->first();
        if($address){
            return response()->json([
                "status"=>200,
                "message"=>'fetch address successfully!',
                "address"=>$address
            ],200);
        }else{
            return response()->json([
                "status"=>404,
                "message"=>'address not found! or not belongs to you',
            ],404);
        }
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
        $address = Address::where('id',$id)->where('user_id',auth()->id())->first();
        if(isset($request->address_name)){
            $address->update(['address_name'=>$request->address_name]);
        }

        if(isset($request->first_name)){
            $address->update(['first_name'=>$request->first_name]);
        }

        if(isset($request->last_name)){
            $address->update(['last_name'=>$request->last_name]);
        }

        if(isset($request->email)){
            $address->update(['email'=>$request->email]);
        }

        if(isset($request->phone)){
            $address->update(['phone'=>$request->phone]);
        }

        if(isset($request->lat)){
            $address->update(['lat'=>$request->lat]);
        }

        if(isset($request->lng)){
            $address->update(['lng'=>$request->lng]);
        }

        if(isset($request->address1)){
            $address->update(['address1'=>$request->address1]);
        }

        if(isset($request->address2)){
            $address->update(['address2'=>$request->address2]);
        }

        if(isset($request->city)){
            $address->update(['city'=>$request->city]);
        }

        if(isset($request->state_id)){
            $address->update(['state_id'=>$request->state_id]);
        }

        if(isset($request->zipCode)){
            $address->update(['zipCode'=>$request->zipCode]);
        }

        if(isset($request->is_primary)){
            $address->update(['is_primary'=>$request->is_primary]);
        }
        return response()->json([
            "status"=>200,
            "message"=>'address updated successfully!',
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address = Address::where('id',$id)->where('user_id',auth()->id())->first();
        if($address){
            if($address->is_primary == 0){
                $address->delete();
                return response()->json([
                    "status"=>200,
                    "message"=>'address deleted successfully!'
                ],200);
            }else{
                return response()->json([
                    "status"=>403,
                    "message"=>'you can\'t delete primary address!'
                ],403);
            }
        }else{
            return response()->json([
                "status"=>404,
                "message"=>'address not found! or not belongs to you',
            ],404);
        }
    }

    public function countries(){
        return response()->json([
            "status"=>200,
            "message"=>'fetch countries successfully!',
            "countries"=>Country::all()
        ]);
    }

    public function states(){
        return response()->json([
            "status"=>200,
            "message"=>'fetch states successfully!',
            "countries"=>State::all()
        ]);
    }
}
