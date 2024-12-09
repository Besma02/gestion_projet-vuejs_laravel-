<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class UserController extends Controller
{

   
   
    public function index(){
    $users=User::with('roles')->get();
    return response()->json([
        'users'=>$users,
        'message'=>'success',
        'code'=>200
        ]);
        }
        public function edit(User $user)
    {
        $user->load('roles');
        $roles = Role::all();
        return response()->json([
            'user' => $user,
            'roles' => $roles
        ]);
    }
    // app/Http/Controllers/UserController.php
public function getUser()
{
    return response()->json(auth()->user());
}

    public function update(User $user, Request $request)
    {
        $request->validate([
            'roles' => ['array', 'exists:roles,id']
        ]);

        $user->roles()->sync($request->input('roles'));

        return response()->json([
            'message' => 'User roles updated successfully!'
        ]);
    }
    
   
}
