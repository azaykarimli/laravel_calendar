<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //show the register form
    public function register_form()
    {
        return view('users.register');
    }
    //register the user
    public function register(Request $request)
    {
        //dd($request);

        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => 'required|confirmed|min:3'
        ]);
        //hash the passwords
        $formFields['password'] = bcrypt($formFields['password']);

        //create user
        $user = User::create($formFields);

        //Login
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in');
    }

    public function logout(Request $request)
    {
        //dd($request);
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'U have been logged out');
    }

    public function login_form()
    {
        return view('users.login');
    }

    public function login(Request $request)
    {
       
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);
        
        if (auth()->attempt($formFields)) {
            //dd($request);
            $request->session()->regenerate();
            return redirect('/')->with('message', 'U have been logged in');
        } else {
            //dd($formFields);
            return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
        }
    }
}
