<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SystemSettingsController extends Controller
{
    public function index(){
        $users = User::latest()->get();
        return view('settings.index', compact('users'));
    }
    public function storeUser(Request $request){
        $request->validate([
            'name'=>'required','email'=>'required|email|unique:users',
            'password'=>'required|min:6','role'=>'required'
        ]);
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>$request->role
        ]);
        return back()->with('success','تم إضافة المستخدم');
    }
    public function deleteUser($id){
        User::findOrFail($id)->delete();
        return back()->with('success','تم الحذف');
    }
}
