<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class SystemSettingsController extends Controller
{
    public function index()
    {
        return view('system-settings.index', [
            'company' => Company::first(),
            'users' => User::latest()->get(),
            'logs' => \DB::table('login_logs')->join('users','users.id','=','login_logs.user_id')->latest('login_at')->limit(50)->get(),
        ]);
    }

    public function storeCompany(Request $r)
    {
        $data = $r->validate(['name'=>'required','email'=>'nullable|email','phone'=>'nullable','address'=>'nullable']);
        Company::firstOrCreate(['id'=>1])->update($data);
        return back()->with('success','تم حفظ بيانات الشركة');
    }

    public function storeLogo(Request $r)
    {
        $r->validate(['logo'=>'required|image|max:2048']);
        $path = $r->file('logo')->store('logos','public');
        Company::firstOrCreate(['id'=>1])->update(['logo'=>$path]);
        return back()->with('success','تم تحديث الشعار');
    }

    public function storeUser(Request $r)
    {
        $r->validate(['name'=>'required','email'=>'required|unique:users','password'=>'required|min:6','role'=>'required']);
        User::create(['name'=>$r->name,'email'=>$r->email,'password'=>bcrypt($r->password),'role'=>$r->role]);
        return back()->with('success','تم إنشاء المستخدم');
    }

    public function deleteUser($id)
    {
        if(auth()->id() == $id) return back()->with('error','لا يمكنك حذف نفسك');
        User::findOrFail($id)->delete();
        return back()->with('success','تم الحذف');
    }

    public function downloadBackup()
    {
        Artisan::call('config:clear');
        $file = 'backup_'.now()->format('Y-m-d').'.sql';
        return response()->streamDownload(function(){ echo "-- backup placeholder --"; }, $file);
    }

    public function clean()
    {
        Artisan::call('optimize:clear');
        return back()->with('success','تم تنظيف النظام');
    }

    // للمستقبل: ضيف هنا أي دالة جديدة وما تهبش الفوق
    // public function storeX() {}
}
