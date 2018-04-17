<?php

namespace FitHabit\Http\Controllers\Api;

use Illuminate\Http\Request;
use FitHabit\Http\Controllers\Controller;
use FitHabit\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class PicuploadController extends Controller
{
   public function uploaduserprofilepic(Request $request)
   {
       $token = $request->input('token');
       $user = JWTAuth::toUser($token);
       $userid = $user->id;

       if($request->hasFile('profilepic')) {
           $fileName = 'profile'.$userid. '.png';

           $request->file('profilepic')->move(
               base_path() . '/public/images/dashboard/profilepic/'.$userid.'/', $fileName
           );

           $url = 'images/dashboard/profilepic/'.$userid.'/'.$fileName;
           $user->user_profilepicurl = $url;
           $user->save();
           return response()->json(['result'=>true, 'url'=>$url]);
       }
       return response()->json(['result'=>false]);
   }

    public function uploadinitialpic(Request $request)
    {
        $token = $request->input('token');
        $user = JWTAuth::toUser($token);
        $userid = $user->id;

        if($request->hasFile('initialpic')) {
            $fileName = 'initial'.$userid. '.png';


            $request->file('initialpic')->move(
                base_path() . '/public/images/dashboard/initialpic/'.$userid.'/', $fileName
            );
            $url = 'images/dashboard/initialpic/'.$userid.'/'.$fileName;
            $user->user_initialpicurl = $url;
            $user->save();

            return response()->json(['result'=>true]);
        }
        return response()->json(['result'=>false]);
    }
}
