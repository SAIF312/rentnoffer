<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChangePasswordRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\OtpRequest;
use App\Http\Requests\Api\UpdatePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $request['full_name'] = $request->first_name . ' ' . $request->last_name;
        $request['password'] = Hash::make($request->password);
        $user = User::create($request->except('confirmPassword'));
        if ($user) {
            $user->attachRole('user');
            $stripeCustomer = $user->createAsStripeCustomer();
            $otp = 11111; //rand(11111,99999);
            // setup email
            $user->update(['otp' => $otp]);
            return response()->json([
                "status" => "200",
                "message" => "Verify your email",
            ], 200);
        }
    }
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if ($user->email_verification == 1) {
                    if ($user->phone_verification == 1) {
                        if ($user->status_id == 7) {
                            return response()->json([
                                "status" => "403",
                                "message" => "User blocked, please contact to admin",
                            ], 403);
                        } else {
                            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                            return response()->json([
                                "status" => "200",
                                "message" => "User loged in successfully",
                                "user" => $user,
                                "token" => $token,
                            ], 200);
                        }
                    } else {
                        $otp = 11111; //rand(11111,99999);

                        // setup message

                        $user->update(['otp' => $otp]);
                        return response()->json([
                            "status" => "403",
                            "message" => "Verify your phone first!",
                        ], 403);
                    }
                } else {
                    $otp = 11111; //rand(11111,99999);

                    // setup email

                    $user->update(['otp' => $otp]);
                    return response()->json([
                        "status" => "403",
                        "message" => "Verify your email first!",
                    ], 403);
                }
            } else {
                return response()->json([
                    "status" => "401",
                    "message" => "Credientials does not match!",
                ], 401);
            }
        } else {
            return response()->json([
                "status" => "404",
                "message" => "User does not exist!",
            ], 404);
        }
    }

    public function verify_email(OtpRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($request->otp == $user->otp) {
            $otp = 22222; //rand(11111,99999);

            ///////////////// setup message//////////////////////

            $user->update(['email_verification' => 1, 'otp' => $otp]);

            return response()->json([
                "status" => "200",
                "message" => "Verify your number",
            ], 200);
        } else {
            return response()->json([
                "status" => "403",
                "message" => "otp mismatch",
            ], 403);
        }
    }

    public function verify_phone(OtpRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($request->otp == $user->otp) {
            $user->update(['phone_verification' => 1, 'otp' => null]);
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            return response()->json([
                "status" => "200",
                "message" => "User logedin successfully",
                "user" => $user,
                "token" => $token,
            ], 200);
        } else {
            return response()->json([
                "status" => "403",
                "message" => "otp mismatch",
            ], 403);
        }
    }

    public function forget_password(Request $request)
    {
        $user = null;
        if (isset($request->username)) {
            $user = User::where('username', $request->username)->first();
        } else if (isset($request->email)) {
            $user = User::where('email', $request->email)->first();
        } else {
            $user = User::where('phone', $request->phone)->first();
        }

        if ($user) {
            if ($user->email_verification == 1) {
                if ($user->phone_verification == 1) {
                    $otp = 33333; //rand(11111,99999);

                    $user->update(['otp' => $otp]);
                    if ($request->type == "email") {

                        /////setup mail//////////////////////////////

                        return response()->json([
                            "status" => "200",
                            "message" => "Check your email!",
                        ], 200);
                    } else {

                        /////setup message/////////////////////////////

                        return response()->json([
                            "status" => "200",
                            "message" => "Check your phone!",
                        ], 200);
                    }
                } else {
                    $otp = 11111; //rand(11111,99999);

                    // setup message

                    $user->update(['otp' => $otp]);
                    return response()->json([
                        "status" => "403",
                        "message" => "Verify your phone first!",
                    ], 403);
                }
            } else {
                $otp = 11111; //rand(11111,99999);

                // setup email

                $user->update(['otp' => $otp]);
                return response()->json([
                    "status" => "403",
                    "message" => "Verify your email first!",
                ], 403);
            }
        } else {
            return response()->json([
                "status" => "404",
                "message" => "User does not found!",
            ], 403);
        }
    }

    public function match_otp(Request $request)
    {

        $user = null;
        if (isset($request->username)) {
            $user = User::where('username', $request->username)->first();
        } elseif (isset($request->email)) {
            $user = User::where('email', $request->email)->first();
        } else {
            $user = User::where('phone', $request->phone)->first();
        }
        if ($request->otp == $user->otp) {
            $user->update(['mismatch_limit' => 0, 'otp' => null]);
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            return response()->json([
                "status" => "200",
                "message" => "User logedin successfully",
                "user" => $user,
                "token" => $token,
            ], 200);
        } else {
            if ($user->mismatch_limit < 9) {
                $limit = $user->mismatch_limit + 1;
                $user->update(['mismatch_limit' => $limit]);
                return response()->json([
                    "status" => "403",
                    "message" => (10 - $limit) . " Trial left, you will be block!",
                ], 403);
            } else {
                $user->update(['status_id' => 7]);
                return response()->json([
                    "status" => "403",
                    "message" => "You are blocked, please contact to admin",
                ], 403);
            }
            $user->update(['mismatch_limit' => $user->mismatch_limit + 1]);
        }
    }

    public function change_password(ChangePasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->password)]);
        return response()->json([
            "status" => "200",
            "message" => "Password changed successfully",
        ], 200);
    }

    public function update_password(UpdatePasswordRequest $request)
    {
        if (Hash::check($request->old_password, auth()->user()->password)) {
            auth()->user()->update(['password' => Hash::make($request->password)]);
            return response()->json([
                "status" => "200",
                "message" => "Password updated successfully",
            ], 200);
        } else {
            return response()->json([
                "status" => "403",
                "message" => "Old password mismatch!",
            ], 200);
        }
    }
}