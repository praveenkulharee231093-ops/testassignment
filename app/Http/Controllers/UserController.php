<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\ValidatedInput;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = Cache::get('users');
        if (!$users) {
            $users = User::with('posts')->get();
            Cache::put('users', $users, now()->addMinutes(10));
        }
        return view('users.index', ['users' => $users]);
    }
    public function create(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $role = $request->input('role');

        return view('users.create', compact('name', 'email', 'role'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);
 
        if ($validator->fails()) {
            logger()->info('Validation failed', ['errors' => $validator->errors()]);
            return back()->withErrors($validator)->withInput();
        }
        $insert = User::create($request->all());
        if($insert){
            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } else {
            return back()->with('error', 'Failed to create user. Please try again.');
        }
        return view('users.store');
    }
    
    public function view(Request $request)
    {
        $id = $request->route('id');
        $getUser = User::find($id);
        if (!$getUser) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
        return view('users.view', ['user' => $getUser]);
    }
}
