<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\User;
use App\Models\RoleUser;

use App\Http\Resources\UserResource;


class EmployeeController extends Controller
{
    public function index(){
        $users = User::all();
        return response()->json(UserResource::collection($users));
    }   
    
    public function store(Request $request){

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
             'id' => $user->id
         ];
 
         return response()->json($response, 200 );
    }

    public function show($id){
        $user = User::with('roles')->find($id);
        return response()->json($user);
    }

    public function update(Request $request, $id){
        $user = User::find($id);
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user->update($input);
        return response()->json(['success'=>'true'], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->blocked = !$user->blocked;
        $user->save();
        return response()->json(['success'=>'true'], 200);
    }

    public function login(Request $request) {
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];
    
        $user = User::where('email', $request->email)->first();
        
        // Kiểm tra xem tài khoản đã bị khóa chưa
        if ($user && $user->blocked == 0) {
            $response = [
                'success' => false,
                'message' => 'Tài khoản của bạn đã bị khóa'
            ];
            return response()->json($response);
        }
        
        if (Auth::guard('web')->attempt($arr)) {
            $response = [
                'success' => true,
                'token' => $user->createToken('MyApp')->plainTextToken,
                'user' =>  $user,
                'message' => "User login successfully"
            ];
    
            return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'message' => 'Tài khoản hoặc mật khẩu không đúng!'
            ];
            return response()->json($response);
        }
    }
    

    public function addRoleToUser(Request $request, $userId)
    {
        $roles = $request->input('roles');
        foreach($roles as $value){
            $roleUser = new RoleUser;
            $roleUser->role_id = $value;
            $roleUser->user_id = $userId;
            $roleUser->save();
        }
        return response()->json(['success' => true]);
    }

    public function updateRoleToUser(Request $request, $userId)
    {
        $roles = $request->input('roles');

        // Xóa tất cả các bản ghi RoleUser hiện có cho user đã cho
        RoleUser::where('user_id', $userId)->delete();
        
        foreach($roles as $value){
            $roleUser = new RoleUser;
            $roleUser->role_id = $value;
            $roleUser->user_id = $userId;
            $roleUser->save();
        }

        return response()->json(['success' => true]);
    }

    
}
