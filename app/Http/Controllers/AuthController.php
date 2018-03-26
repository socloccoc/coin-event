<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{

    public function ShowloginForm()
    {
        return view('login.index');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:3|max:32'
        ]);
        if (Auth::attempt(['email'=>'admin@gmail.com','password' => $request->password])) {
            return redirect('/');
        } else {
            return redirect('login')->with('messages', 'Đăng nhâp không thành công');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('login');
    }
}
