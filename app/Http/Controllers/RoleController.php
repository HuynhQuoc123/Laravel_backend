<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionRole;


class RoleController extends Controller
{
    public function index(){
        $roles = Role::all();
        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $role = new Role();
        $role->name = $request->name;
        $role->save();

        return response()->json(['success' => true, 'id' => $role->id]);
    }

    public function show($id){
        $role = Role::with('permissions')->find($id);
        return response()->json($role);
    }

    public function update(Request $request, $id){
        $role = Role::find($id);
        $role->update($request->all());
        return response()->json(['success'=>'true'], 200);
    }

    public function addPermissionToRole(Request $request, $idRole)
    {
        $permissions = $request->input('permissions');
    
        foreach($permissions as $value){
            $permissionRole = new PermissionRole;
            $permissionRole->permission_id = $value;
            $permissionRole->role_id = $idRole;
            $permissionRole->save();
        }     
      
            return response()->json(['success' => true]);
    }

    public function updateRolePermissions(Request $request, $idRole)
    {
        $permissions = $request->input('permissions');
        
        // Xóa tất cả các quyền của role cũ trước khi thêm quyền mới
        PermissionRole::where('role_id', $idRole)->delete();
        
        // Thêm quyền mới cho role
        foreach($permissions as $value){
            $permissionRole = new PermissionRole;
            $permissionRole->permission_id = $value;
            $permissionRole->role_id = $idRole;
            $permissionRole->save();
        }     
        
        return response()->json(['success' => true]);
    }

}
