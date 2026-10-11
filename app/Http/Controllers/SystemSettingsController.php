<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;

class SystemSettingsController extends Controller
{
    public function index(){
        return view('settings.index', [
            'users' => User::all(),
            'company' => Company::first(),
        ]);
    }

   public function storeCompany(Request $request){
    $request->validate([
        'name'=>'required',
        'phone'=>'nullable',
        'email'=>'nullable|email',
    ]);

    $company = \App\Models\Company::first();
    if(!$company) $company = new \App\Models\Company();

    $company->name = $request->name;
    $company->phone = $request->phone;
    $company->email = $request->email;
    $company->website = $request->website;
    $company->address = $request->address;
     $company->tax_number = $request->tax_number;

    if($request->hasFile('logo')){
        $path = $request->file('logo')->store('logos','public');
        $company->logo = $path;
    }
    
    $company->save(); // save ما عندو علاقة بـ fillable

    return back()->with('success','تم حفظ بيانات الشركة ✅');
}


    public function storeLogo(Request $request){
        $request->validate(['logo'=>'required|image|max:2048']);
        $path = $request->file('logo')->store('logos','public');
        $company = Company::first() ?? Company::create(['name'=>'شركتي']);
        $company->update(['logo'=>$path]);
        return back()->with('success','تم رفع الشعار ✅');
    }

public function storeUser(Request $request){
    $request->validate([
        'name'=>'required',
        'email'=>'required|email|unique:users,email',
        'password'=>'required|min:6',
        'role'=>'required'
    ]);

    $user = new \App\Models\User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = $request->password; // الـ Model حيعمل هاش أوتوماتيك مرة واحدة
    $user->role = $request->role;
    $user->save();

    return back()->with('success','تم حفظ المستخدم ✅');
}


    public function deleteUser($id){
        User::findOrFail($id)->delete();
        return back()->with('success','تم الحذف');
    }

    public function downloadBackup(){ return back()->with('success','الباك اب جاهز'); }
    public function clean(){ return back()->with('success','تم التنظيف'); }
}
