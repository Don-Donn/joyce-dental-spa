<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function registrationPage()
    {
        return view('auth.register');
    }

    public function postRegister()
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8', // Minimum 8 characters
                'confirmed',
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[\W_]/', // At least one special character
                'regex:/(\d.*\d)/', // At least two numbers
            ],
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'birthday' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
        ]);
    
        $data['password'] = bcrypt($data['password']);
        $data['type'] = 'Patient'; // default value for type
        $user = User::create($data);
    
        return back()->withSuccess('success');
    }
    
}
