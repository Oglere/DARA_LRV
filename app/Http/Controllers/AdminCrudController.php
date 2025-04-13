<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rule;

class AdminCrudController extends Controller
{
    public function create(Request $request) {
        $createUser = $request->validate([
            'first_name' => 'required',
            'last_name'=> 'required',
            'usn'=> 'required',
            'email'=> 'required',
            'password_hash'=> ['nullable','min:8'],
            'role' => 'required',
            'status' => 'required',
        ]);

        $createUser['password_hash'] = $request->filled('password_hash') 
            ? Hash::make($request->password_hash) 
            : Hash::make('defaultpassword'); 

        User::create($createUser);

        return redirect('/admin/user-control')->with('success', 'User created successfully!');
    }

    public function edit(Request $request, $id){
        $user = User::findOrFail($id);

        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'status' => $request->input('status'),
            'password' => $request->filled('password_hash') ? Hash::make($request->input('password_hash')) : $user->password,
        ]);

        return redirect()->back()->with('success', 'User updated successfully!');
    }   
    public function delete(Request $request, $id){
        $user = User::findOrFail($id);
        $user->update(['status' => 'Deleted']);
    
        return redirect()->back()->with('success', 'User updated successfully!');
    }   

    public function recover(Request $request, $id){
        $user = User::findOrFail($id);
        $user->update(['status' => 'Active']);
    
        return redirect()->back()->with('success', 'User updated successfully!');
    }   

    public function editacc(Request $request, $id){
        $user = User::findOrFail($id);

        $request->validate([
            'password_hash' => 'required'
        ]);

        if (!Hash::check($request->password_hash, $user->password_hash)) {
            return back()->withErrors(['Invalid credentials or inactive account.']);
        }

        $editFormHtml = view('admin.show', compact('user'))->render();

        return back()->with('editForm', $editFormHtml);
    } 
    

    public function updateacc(Request $request, $id) {
        $user = User::findOrFail($id);
    
        $updateUser = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id, 'user_id'), // Specify the correct primary key column
            ],
            'password_hash' => ['nullable', 'min:8'],
        ]);
    
        if ($request->filled('password_hash')) {
            $updateUser['password_hash'] = Hash::make($request->password_hash);
        } else {
            unset($updateUser['password_hash']); 
        }
    
        $user->update($updateUser);
    
        return redirect()->back()->with('success', 'Account updated successfully!');
    }
    
}
