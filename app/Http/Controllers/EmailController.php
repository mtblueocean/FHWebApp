<?php

namespace FitHabit\Http\Controllers;

use FitHabit\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    //
    var $sendmail = "";
    public function sendResetPWDEmail(Request $request)
    {
        $input = $request->all();
        $email = $input['email'];
        $this->sendmail = $email;
        $user = User::where('email', $email)->first();
        if($user == null)
        {
            return response()->json(['result' => false, 'message' => 'Not exist email.']);
        }
        else
        {
            $resetcode = $this->generatePwdResetString();
            $user->resetcode = $resetcode;
            $user->save();
            Mail::send('resetCode', ['title' => 'asdfasdf', 'content' => 'asdfasdfasdfs', 'code' => $resetcode], function ($message)
            {
                $message->from('admin@fithabit.io', 'FH Support')->subject('Your Password Reset Code.');
                $message->to($this->sendmail);
            });
            return response()->json(['result' => true, 'message' => 'success']);
        }

//        return response()->json(['message' => 'Request completed']);
    }

    function generatePwdResetString($length = 5) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
