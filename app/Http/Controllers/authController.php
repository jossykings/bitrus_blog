<?php

namespace App\Http\Controllers;

use App\posts;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    public function register()
    {
        return view('register');
    }
    public function welcome()
    {
        $post = posts::orderBy('created_at', 'desc')->limit(6)->get();
        return view('welcome')->with([
            'posts' => $post
        ]);
    }
    public function userstore(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',

        ]);
        $user = new User();
        $user->name = request('name');
        $user->username = request('username');
        $user->email = request('email');
        $user->password = bcrypt(request('password'));
        $user->save();
        auth()->login($user);
        return redirect()->route('welcome');
    }
    public function login()
    {
        return view('login');
    }
    public function loginuser(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            auth()->login($user);
            if ($user->role == '1') {
                return redirect()->route('dashboard')->with('success', "welcome $user->name");
            } else {
                return redirect()->route('welcome')->with('success', "welcome $user->name");
            }
        } else {
            return back()->with('error', 'invalid credentials');
        }
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function create()
    {
        return view('admin.create');
    }
    public function admindashboard()
    {
        $posts = posts::orderBy('created_at', 'desc')->get();
        $users = User::where('role', '0')->get();
        $admin = User::where('role', '1')->get();
        // dd($admin);
        return view('admin.dashboard')->with([
            'posts' => $posts,
            'users' => $users,
            'admin' => $admin
        ]);
    }
    public function addtoadmin($id)
    {
        $user = User::find($id);
        $user->role = '1';
        $user->save();
        return back()->with('success', 'Added successfully');
    }
    public function removeadmin($id)
    {
        $user = User::find($id);
        $user->role = '0';
        $user->save();
        return back()->with('success', 'Added Removed');
    }
    public function deleteuser($id)
    {
        $user = User::find($id);
        if ($user->likes->count() > 0) {
            $user->likes->where('user_id', $id)->delete();
        }
        if ($user->comment->count() > 0) {
            foreach ($user->comment as $item) {
                $item->delete();
            }
        }
        $user->delete();
        return back()->with('success', 'User deleted');
    }
}
