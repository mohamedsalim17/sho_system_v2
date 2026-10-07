<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){ $users = User::all(); return view('users.index', compact('users')); }
    public function create(){ return view('users.create'); }
    public function store(Request $request){
        $request->validate(['name'=>'required','email'=>'required|unique:users','password'=>'required','role'=>'required']);
        User::create(['name'=>$request->name,'email'=>$request->email,'role'=>$request->role,'password'=>Hash::make($request->password)]);
        return redirect()->route('users.index');
    }
    public function edit(User $user){ return view('users.edit', compact('user')); }
    public function update(Request $request, User $user){
        $user->update(['name'=>$request->name,'email'=>$request->email,'role'=>$request->role]);
        if($request->password) $user->update(['password'=>Hash::make($request->password)]);
        return redirect()->route('users.index');
    }
    public function destroy(User $user){ $user->delete(); return back(); }
}
