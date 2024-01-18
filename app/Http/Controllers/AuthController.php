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
            'phone'     => ['required','unique:users','regex:/^(84[3|5|7|8|9]|0[3|5|7|8|9])+([0-9]{8})\b$/'],
            'password'  => 'required|min:4|confirmed',
        ]);        
        if ($validate->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
        }        
        $user = new User;
        $user->name = $request->name;
        $user->phone = u::convertPhoneNumber($request->phone);
        $user->password = bcrypt($request->password);
        $user->status = 'Active';
        $user->save(); 
        
        $credentials = request(['phone', 'password']);
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
      
        return $this->respondWithToken($token, $request->phone);
    } 

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request(['phone', 'password']);
        $credentials['phone'] = u::convertPhoneNumber($credentials['phone']);

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token, $request->phone);
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
}