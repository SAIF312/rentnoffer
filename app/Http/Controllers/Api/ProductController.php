<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Api\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Type;
use App\Models\Day;
use App\Models\Time;
use App\Models\Media;
use App\Models\Slot;
use App\Models\Address;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products  = Product::where('user_id',auth()->id())->get();
        if(count($products)){
            return response()->json([
                "status"=>200,
                "message"=>'fetch products successfully!',
                "products"=>$products
            ],200);
        }else{
            return response()->json([
                "status"=>404,
                "message"=>'you don\'t have any product!',
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        // return $request->all();
        // dd($request->media_files);

        try{
            $request['user_id'] = auth()->id();
            $request['status_id'] = 1;
            if($request->hasFile('cover')){
                $file      = $request->file('cover');
                $file_path = Storage::put('public/product/cover', $file);
                $file_path = str_replace("public","storage",$file_path);

                $request['feature_image'] = $file_path;

            }

            $product = Product::create($request->except(['cover','media_files','available_slots','address1','address2','city','state_id','zipcode']));
            $media_files = json_decode($request->media_files);
            foreach ($media_files->medias as $media){
                Media::create([
                    'product_id'=>$product->id,
                    'type'=>$media->type,
                    'url'=>$media->url
                ]);
            }

            $available_slots = json_decode($request->available_slots);

            foreach ($available_slots->availables as $available){
                if(count($available->time_ids) > 0){
                    foreach($available->time_ids as $time_id){
                        Slot::create([
                            'product_id'=>$product->id,
                            'day_id'=>$available->day_id,
                            'time_id'=>$time_id
                        ]);
                    }
                }else{
                    if($product->type_id == 1){
                        Slot::create([
                            'product_id'=>$product->id,
                            'day_id'=>$available->day_id,
                            'time_id'=>null
                        ]);
                    }else{
                        for($i=1; $i<=24; $i++){
                            Slot::create([
                                'product_id'=>$product->id,
                                'day_id'=>$available->day_id,
                                'time_id'=>$i
                            ]);
                        }
                    }

                }
            }

            Address::create([
                'product_id'=>$product->id,
                "lat"=>$request->lat,
                "lng"=>$request->lng,
                "address1"=>$request->address1,
                "address2"=>$request->address2,
                "city"=>$request->city,
                "state_id"=>$request->state_id,
                "zipcode"=>$request->zipcode,
                "first_name"=>auth()->user()->first_name,
                "last_name"=>auth()->user()->last_name,
                "email"=>auth()->user()->email,
                "phone"=>auth()->user()->phone,

            ]);

            return response()->json([
                "status"=>200,
                "message"=>'product added successfully!',
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
        $product = Product::where('id',$id)->with('slots','images','video','address','type','category','user')->first();

        if($product){
            if(auth()->id()!=$product->user_id){
                $product->update(['views'=>(int)($product->views)+1]);
            }

            return response()->json([
                "status"=>200,
                "message"=>'fetch product successfully!',
                "product"=>$product
            ],200);
        }else{
            return response()->json([
                "status"=>404,
                "message"=>'product not found!',
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
        //
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
        $product = Product::where('id',$id)->first();
        $address = Address::where('product_id',$product->id)->first();

        if(isset($request->type_id)){
            $product->update(['type_id'=>$request->type_id]);
        }

        if(isset($request->category_id)){
            $product->update(['category_id'=>$request->category_id]);
        }

        if(isset($request->name)){
            $product->update(['name'=>$request->name]);
        }

        if(isset($request->short_description)){
            $product->update(['short_description'=>$request->short_description]);
        }

        if(isset($request->description)){
            $product->update(['description'=>$request->description]);
        }

        if(isset($request->rule_for_use)){
            $product->update(['rule_for_use'=>$request->rule_for_use]);
        }

        if(isset($request->privacy_notes)){
            $product->update(['privacy_notes'=>$request->privacy_notes]);
        }

        if(isset($request->price1)){
            $product->update(['price1'=>$request->price1]);
        }

        if(isset($request->price7)){
            $product->update(['price7'=>$request->price7]);
        }

        if(isset($request->price30)){
            $product->update(['price30'=>$request->price30]);
        }

        if(isset($request->minimum_rent_days)){
            $product->update(['minimum_rent_days'=>$request->minimum_rent_days]);
        }

        if(isset($request->value)){
            $product->update(['value'=>$request->value]);
        }

        if($request->hasFile('cover')){
            $old_image = null;
            if(isset($product->feature_image)){
                $old_image = $product->feature_image;
            }

            $file      = $request->file('cover');
            $file_path = Storage::put('public/product/cover', $file);
            $file_path = str_replace("public","storage",$file_path);
            $flag = $product->update(['feature_image' => $file_path]);
            if($flag){
                file_exists(public_path().'/'.$old_image) ? unlink(public_path().'/'.$old_image):'';
            }
        }

        if(isset($request->lat)){
            $product->update(['lat'=>$request->lat]);
            $address->update(['lat'=>$request->lat]);
        }

        if(isset($request->lng)){
            $product->update(['lng'=>$request->lng]);
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

        if(isset($request->zipcode)){
            $address->update(['zipcode'=>$request->zipcode]);
        }

        if(isset($request->media_files)){
            $media_files = json_decode($request->media_files);
            foreach ($media_files->medias as $media){

                $i = 1;
                $j = 1;
                if($media->type == 'video' && $i>1){
                    $video = Media::where('product_id',$product->id)->where('type',$media->type)->delete();
                    $i++;
                }elseif($media->type == 'img' && $j>1){
                    $image = Media::where('product_id',$product->id)->where('type',$media->type)->delete();
                    $j++;
                }

                Media::create([
                    'product_id'=>$product->id,
                    'type'=>$media->type,
                    'url'=>$media->url
                ]);

            }
        }

        return response()->json([
            "status"=>200,
            "message"=>"updated successfully!"
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
        //
    }

    public function product_status(Request $request, $id){
        // lender can enable and disable product status
        $product = Product::where('id',$id)->where('user_id',auth()->id())->first();
        if($product){
            $product->update(['status_id'=>$request->status_id]);
            return response()->json([
                "status"=>200,
                "message"=>'status updated successfully!'
            ],200);
        }else{
            return response()->json([
                "status"=>404,
                "message"=>'product not found, or doesn\'t belongs to you',
            ],404);
        }
    }

    public function favourite(Request $request){
        if(Product::where('id', $request->id)->exists()){
            if(auth()->user()->favourites->contains($request->id)){
                auth()->user()->favourites()->detach($request->id);
                return response()->json([
                    "status"=>200,
                    "message"=>'product unfavourite successfully!',
                ],200);
            }else{
                auth()->user()->favourites()->attach($request->id);
                return response()->json([
                    "status"=>200,
                    "message"=>'product favourite successfully!',
                ],200);
            }
        }else{
            return response()->json([
                "status"=>404,
                "message"=>'product not found!',
            ],404);
        };
    }

    public function wishlist(Request $request){
        if(Product::where('id', $request->id)->exists()){
            if(auth()->user()->wishlist->contains($request->id)){
                auth()->user()->wishlist()->detach($request->id);
                return response()->json([
                    "status"=>200,
                    "message"=>'product removed from wishlist successfully!',
                ],200);
            }else{
                auth()->user()->wishlist()->attach($request->id);
                return response()->json([
                    "status"=>200,
                    "message"=>'product added to wishlist successfully!',
                ],200);
            }
        }else{
            return response()->json([
                "status"=>404,
                "message"=>'product not found!',
            ],404);
        };
    }

    public function categories(){
        return response()->json([
            "status"=>200,
            "message"=>'fetch categories successfully!',
            "categories"=>Category::all()
        ],200);
    }

    public function types(){
        return response()->json([
            "status"=>200,
            "message"=>'fetch types successfully!',
            "types"=>Type::all()
        ],200);
    }

    public function add_media_files(Request $request){
        Log::info($request->all());

        $this->validate($request, [
            'media' => 'mimes:jpg,jpeg,png,mp4',
            'type'=>'required'
        ]);

        if($request->hasFile('media')){
            $media['type'] = ( $request->type == 'video' ) ? "video" : "image";

            $file      = $request->file('media');
            $file_path = Storage::put('public/product/'.$media['type'], $file);
            $media['url'] = str_replace("public","storage",$file_path);

            return response()->json([
                "status"=>200,
                "message"=> $media['type']." uploaded successfully!",
                "media"=> $media

            ],200);
        }
    }

    public function remove_media(Request $request){
        if(file_exists(public_path().'/'.$request->url)){
            unlink(public_path().'/'.$request->url);
            return response()->json([
                "status"=>200,
                "message"=> "file removed successfully!",
            ],200);
        }else{
            return response()->json([
                "status"=>404,
                "message"=> "file not found!",
            ],404);
        };
    }

    public function days(){
        return response()->json([
            "status"=>200,
            "message"=>'fetch days successfully!',
            "categories"=>Day::all()
        ],200);
    }

    public function times(){
        return response()->json([
            "status"=>200,
            "message"=>'fetch times successfully!',
            "categories"=>Time::all()
        ],200);
    }
}
