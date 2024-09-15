<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\otpMail;
use App\Helper\JWTtoken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Console\Input\Input;

class userController extends Controller
{

public function userLoginPage(){
    return view('pages.auth.login-page');
}

public function userRegistrationPage(){
    return view('pages.auth.registration-page');
}
public function sendOtp(){
    return view('pages.auth.send-otp-page');
}

public function verifyOtp(){
    return view('pages.auth.verify-otp-page');
}
public function resetPass(){
    return view('pages.auth.reset-pass-page');
}

public function userDashboard(){
    return view('pages.dashboard.dashboard-page');
}
public Function profilePage (){
    return view('pages.dashboard.profile-page');

}



    public function userRegistration(Request $request)
    {

        try {
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => $request->input('password'),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => "User Registration successfully",
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => "User Registration Failed",
            ],401);
        }

    }

    public function userLogin(Request $request)
    {
        $count = User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->select('id')->first();

        if ($count !== null) {
            $token = JWTtoken::createToken($request->input('email'),$count->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Log in Successfully',
                
            ], 200)->cookie('token', $token , 60*24*30) ;

         }
         else{
            return response()->json([
               'status' => 'Failed',
               'message' => 'unauthorized'
           ], 401);
         }

    }


    public function sendOTPCode (Request $request){
        $email = $request->input('email');
        $otp = rand(1000,9999);

        $count = User::where('email','=',$email)->count();

        if( $count == 1){
            
            //send otp mail address
            Mail::to($email)->send(new otpMail($otp));

            //database otp update
            User::where('email','=',$email)->update(['otp'=>$otp]);

            return response()->json([
                'status' => 'success',
                'message' => '4 Digit OPT Send Successful'
            ], 200);


        }
        else{
            return response()->json([
                'status' => 'Failed',
                'message' => 'unauthorized'
            ], 401);
        }

    }


    public function verifyOtpCode(Request $request){
        $email = $request->input('email');
        $otp = $request->input('otp');

        $count = User::where('email','=',$email)
                    ->where('otp','=',$otp)->count();

        if($count == 1){
        //update otp database
        User::where('email','=',$email)->update(['otp'=>'0']);

        //create token
        $token = JWTtoken::createTokenSetPass($request->input('email'));

        return response()->json([
            'status' => 'success',
            'message' => 'Verify Successfully',
            
        ], 200)->cookie('token',$token,60*24*30);

        }
    else{
        return response()->json([
            'status' => 'Failed',
            'message' => 'unauthorized'
        ], 401);
        }                
    }

    public function resetPassword(Request $request){

        try{
            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email','=',$email)->update(['password'=>$password]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password Reset Successful'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Something is Wrong'
            ], 401);
        }               
        

    }

    public function userLogout(){
        return redirect('/userLogin')->cookie('token','',-1);
    }

    public function userProfile (Request $request){
        $email = $request->header('email');
        $user = User::where('email','=',$email)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'Password Reset Successful',
            'data'=> $user
        ], 200);
    }

   
    public function userProfileUpdate (Request $request){
        try {
            $email = $request->header('email');
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $mobile = $request->input('mobile');
        $password = $request->input('password');
        User::where('email','=',$email)->update([
            'firstName'=>$firstName,
            'lastName'=>$lastName,
            'mobile'=>$mobile,
            'password'=>$password
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Update Successful'
        ], 200);
            
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Something is Wrong'
            ], 401);
        }
        
    }   
    
}
