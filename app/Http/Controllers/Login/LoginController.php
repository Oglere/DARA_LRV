<?php

namespace App\Http\Controllers\Login;
use App\Models\User;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Session;

class LoginController extends Controller
{       


    public function showLoginForm(){
        return view('go.login');
    }

    public function list() {
        $user = User::get(); 

        return view('/lists', ['user'=> $user]);
    }

    public function login(Request $request) {
        $incomingFields = $request->validate([
            'usn_login' => 'required',
            'password_hash_login' => 'required'
        ]);
    
        $user = User::where('usn', $incomingFields['usn_login'])->first();
    
        if ($user && Hash::check($incomingFields['password_hash_login'], $user->password_hash)) {
            if ($user->status == "Deleted") {
                return back()->withErrors(['Error' => 'Account suspended.']);
            } else {
                Auth::login($user);
                $request->session()->regenerate();
        
                // Role-based redirection
                return match ($user->role) {
                    'Admin' => redirect('admin'),
                    'Teacher' => redirect('teacher'),
                    'Student' => redirect('student'),
                    default => back()->withErrors(['Error' => 'Invalid role'])
                };
            }
            
            
        } else {
            return back()->withErrors(['Error' => 'Invalid credentials.']);
        }
    
    }
    
    public function recovery() {
        if (Auth::check()) {
            return redirect('/');
        }

        return view('go.recovery');
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $user->update(['last_login' => now()]);
        }
        auth::logout();
        Session::flush();
        Redirect::back();
        return redirect::to('/go/login');
    }


}
