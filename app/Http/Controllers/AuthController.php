<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Providers\UtilityServiceProvider as u;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{ 
   
    /**
     * Register new user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){
        $validate = Validator::make($request->all(), [
            'name'      => 'required',
            'email'      => ['required', 'email', 'unique:users'],
            // 'phone'     => ['required','unique:users','regex:/^(84[3|5|7|8|9]|0[3|5|7|8|9])+([0-9]{8})\b$/'],
            'password'  => 'required|min:4|confirmed',
        ]);        
        if ($validate->fails()){
            return response()->json([
                'status' => 0,
                'message' => 'Email đã tồn tại trên hệ thống.'
            ], 200);
        }        
        $user = new User;
        $user->name = $request->name;
        $user->email = u::convertPhoneNumber($request->email);
        // $user->phone = u::convertPhoneNumber($request->phone);
        $user->password = bcrypt($request->password);
        $user->menuroles = 'user';
        $user->status = '0';
        $user->save(); 
        
        return response()->json([
            'status' => 1,
            'message' => 'successfully'
        ]);
    } 

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);
        $user = u::getObject(array('email'=>$request->email), 'users');
        if($user && $user->status!=1){
            return response()->json([
                'status' => 0,
                'type' => 'inactive',
                'message'=>'Tài khoản chưa được kích hoạt, vui lòng truy cập email để kích hoạt.'
            ]);
        }

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'status' => 0, 
                'type' => 'account',
                'message'=>'Email hoặc mật khẩu không chính xác.'
            ]);
        }

        return $this->respondWithToken($token, $request->email);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        
        $this->validate($request, [
            'token' => 'required'
        ]);
        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'status' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $email)
    {
        return response()->json([
            'status' => 1,
            'accessToken' => $token,
            'userData' => [
                'displayName' => auth()->user()->name,
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => auth()->user()->phone,
                'photoURL' => "/images/avatar-s-5.jpg?99691e543d9e33cf745f6ac56f5800b8",
                'providerId' => "jwt",
                'uid' => auth()->user()->id,
                'address' =>  auth()->user()->address,
                'birthday' => auth()->user()->birthday ? date('d/m/Y', strtotime(auth()->user()->birthday )) : null,
                'note' => auth()->user()->note,
                'gender' => auth()->user()->gender,
                'menuroles' => auth()->user()->menuroles,
            ]
        ]);
    }

    public function testMail(){
        $result = Mail::send('mail.test', array('title'=>'Xin Chào', 'content'=>'Nội dung email'), function($message){
	        $message->to('thanhcong1710@gmail.com', 'Visitor')->subject('Visitor Feedback!');
	    });
        var_dump($result);die('ok');
    }
}