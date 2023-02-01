<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\ServiceFee;
use App\Models\Timezone;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::where('id',1)->first();
        $timezones = Timezone::all();
        $service_fee = ServiceFee::where('id',1)->first();
        return view('Layouts.settings.create',compact('setting','timezones','service_fee'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $setting = Setting::where('id',$id)->first();
        if(isset($request->site_title)){
            $setting->update(['site_title'=>$request->site_title]);
        }
        if(isset($request->site_logo_large)){
            $setting->update(['site_logo_large'=>$request->site_logo_large]);
        }
        if(isset($request->site_logo_small)){
            $setting->update(['site_logo_small'=>$request->site_logo_small]);
        }
        if(isset($request->copy_right_text)){
            $setting->update(['copy_right_text'=>$request->copy_right_text]);
        }
        if(isset($request->site_email)){
            $setting->update(['site_email'=>$request->site_email]);
        }
        if(isset($request->address)){
            $setting->update(['address'=>$request->address]);
        }
        if(isset($request->facebook_url)){
            $setting->update(['facebook_url'=>$request->facebook_url]);
        }
        if(isset($request->twitter_url)){
            $setting->update(['twitter_url'=>$request->twitter_url]);
        }
        if(isset($request->linkedin_url)){
            $setting->update(['linkedin_url'=>$request->linkedin_url]);
        }
        if(isset($request->instagram_url)){
            $setting->update(['instagram_url'=>$request->instagram_url]);
        }
        if(isset($request->timezone_id)){
            $setting->update(['timezone_id'=>$request->timezone_id]);
        }
        if(isset($request->contact_us_email)){
            $setting->update(['contact_us_email'=>$request->contact_us_email]);
        }
        if(isset($request->contact_us_email)){
            $setting->update(['contact_us_email'=>$request->contact_us_email]);
        }
        if(isset($request->distance)){
            $setting->update(['distance'=>$request->distance]);
        }
        if(isset($request->s_fee)){
            $service_fee = ServiceFee::where('id',$id)->first();
            $service_fee->update(['s_fee'=>$request->s_fee]);
        }

        return redirect()->route('settings.index');

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
}
