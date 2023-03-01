<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Helpers\Helper;
use App\Http\Resources\UserResource;
use Spatie\Permission\Models\Role;
use App\Models\User;



class RegisterController extends Controller
{
    public function register(RegisterRequest $request){
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password)

        ]);

        $user_role = Role::where(['name' => 'user'])->first();

        if($user_role){
            $user->assignRole($user_role);
        }
        return new UserResource($user);
    }
}
