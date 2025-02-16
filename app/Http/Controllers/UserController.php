<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $row = User::all();
        return view('user.index', compact('row'));
    }
    public function edit($id){
        $row = User::findOrFail($id);
        return view('user.edit', compact('row'));
    }
    public function update(Request $request, $id){
        $row = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'.$id,
            'password' => 'nullable|min:8|confirmed',
        ]);
        $row->update($request->all());
        return redirect()->route('user.index')->with('success','Data Updated Success');
    }
}
