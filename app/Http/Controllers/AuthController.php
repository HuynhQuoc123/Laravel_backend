<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Customer;
class AuthController extends Controller
{
    public function index(){
        $customer = Customer::all();
        return response()->json($customer);
    }
    public function register(Request $request){

       $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|string',
            'password' => 'required',
            'c_password' => 'required|same:password',
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
        $customer = Customer::create($input);
        
        $response = [
            'success' => true,
            'message' => "Customer register successfully"
        ];

        return response()->json($response, 200 );
    }

    public function login(Request $request){
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $customer = Customer::where('email', $request->email)->first();
        
        if(Auth::guard('customer')->attempt($arr)){
            // $customer = Auth::customer();
            
            $response = [
                'success' => true,
                'token' => $customer->createToken('MyApp')->plainTextToken,
                'customer' =>  $customer,
                'message' => "Customer login successfully"
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
