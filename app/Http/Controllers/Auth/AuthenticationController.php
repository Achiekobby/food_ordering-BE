<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//* Models
use App\Models\User;

//* Requests
use App\Http\Requests\Auth\RegisterRequest;

//* Resources
use App\Http\Resources\User\UserDetailsResource;

//* Utilities
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    //TODO => format RegisterInput
    public function formatRegisterDetails(RegisterRequest $request){
        $first_name =Str::title($request->validated()['first_name']);
        $last_name  =Str::title($request->validated()['last_name']);
        $email      =$request->validated()['email'];
        $phone      =$request->validated()['phone'];
        $password   =Hash::make($request->validated()['password']);
        $address    =$request->validated()['address'];
        $city       =Str::title($request->validated()['city']);
        $token      =Str::random(8);

        return [
            'first_name'    =>$first_name,
            'last_name'     =>$last_name,
            'email'         =>$email,
            'phone_number'  =>$phone,
            'password'      =>$password,
            'address'       =>$address,
            'city'          =>$city,
            'remember_token'=>$token,
        ];
    }

    //TODO:: Register a user
    public function register(RegisterRequest $request){
        try{
            $user = User::query()->create($this->formatRegisterDetails($request));
            if($user){
                //* create an access token for the user
                $access_token = $user->createToken(config('services.access_token_key'))->accessToken;

                //* return a response with the details of the newly created user
                return response()->json([
                    'status'=>'success',
                    'message'=>'Welcome to the food ordering application',
                    'user_data'=>new UserDetailsResource($user),
                    'token'=>$access_token
                ],200);
            }
            return response()->json(['status'=>'failed','error'=>'Sorry, a problem occurred during your registration'],400);
        }catch(\Exception $e){
            return response()->json(['status'=>'failed','error'=>$e->getMessage()],500);
        }
    }

    //TODO:: Login a user
    public function login(Request $request){
        $rules =[
            'email'=>'required|email|regex:#^[\w.%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$#',
            'password'=>'required|string'
        ];

        //* Validation
        $validation = Validator::make($request->all(),$rules);
        if($validation->fails()){
            return response()->json(['status'=>'failed','error'=>$validation->errors()->first()],422);
        }

        try{
            //* checking the user email
            $user = User::query()->where('email', $request->email)->first();
            if(!$user){
                return response()->json(['status'=>'failed','error'=>'Sorry, email does not exist in the system'],404);
            }

            //* checking the password
            if(!Hash::check($request->password, $user->password)){
                return response()->json(['status'=>'failed','error'=>'Sorry, Wrong Credentials'],404);
            }

            return response()->json([
                'status'    =>'success',
                'message'   =>'You have successfully signed in',
                'user_data' =>new UserDetailsResource($user),
                'token'     =>$user->createToken(config('services.access_token_key'))->accessToken
            ]);
        }catch(\Exception $e){
            return response()->json(['status'=>'failed','error'=>$e->getMessage()],500);
        }
    }
}
