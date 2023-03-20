<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\User;

class AuthAdminController extends Controller
{
    public function index(){
        $user = User::all();
        return response()->json($user);
    }
    
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
             'name' => 'required',
             'phone' => 'required',
             'email' => 'required|string',
             'password' => 'required',
         ]);
 
         if($validator->fails()){
             $response = [
                 'success' => false,
                 'message' => $validator->errors()
             ];
 
             return response()->json($response, 400 );
         }
 
         $input = $request->all();
         $input['password'] = bcrypt($input['password']);
         $user = User::create($input);
         
         $response = [
             'success' => true,
         ];
 
         return response()->json($response, 200 );
    }

    public function login(Request $request){
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $user = User::where('email', $request->email)->first();
        
        if(Auth::guard('web')->attempt($arr)){
            // $user = Auth::user();
            
            $response = [
                'success' => true,
                'token' => $user->createToken('MyApp')->plainTextToken,
                'user' =>  $user,
                'message' => "user login successfully"
            ];

            return response()->json($response, 200 );
            
        } 
        else {
            $response =[
                'success' => false,
                'message' => 'Unauthorised'
            ];
            return response()->json($response);
        }


    }

    
}
