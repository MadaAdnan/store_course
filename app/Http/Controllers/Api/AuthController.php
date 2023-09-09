<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        $Validator=\Validator::make($request->all(),[
            'email'=>'required',
            'password'=>'required',
        ]);
        if($Validator->fails()){
            return response()->json(['msg'=>$Validator->getMessageBag()->first(),'status'=>'error'],422);
        }
        $user=User::where('email',$request->email)->first();
        if(!$user){
            return response()->json(['msg'=>'بيانات الدخول غير صحيحة','status'=>'error'],422);
        }
        if(!Hash::check($request->password,$user->password)){
            return response()->json(['msg'=>'بيانات الدخول غير صحيحة','status'=>'error'],422);
        }

        $token=$user->createToken('user')->plainTextToken;

        return response()->json(['user'=>new UserResource($user),'token'=>$token]);


    }
}
