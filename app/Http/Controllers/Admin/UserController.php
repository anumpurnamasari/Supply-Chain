<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        return redirect()
            ->route('users.index')
            ->with('success','User created.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit',compact('user'));
    }

    public function update(Request $request,User $user)
    {
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
        ]);

        if($request->filled('password')){
            $user->password=Hash::make($request->password);
            $user->save();
        }

        return redirect()
            ->route('users.index')
            ->with('success','User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success','User deleted.');
    }
}
