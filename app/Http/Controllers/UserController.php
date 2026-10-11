<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. عرض كل حسابات السيستم
    public function index(){ 
        $users = User::with('employee')->latest()->get(); 
        return view('users.index', compact('users')); 
    }

    // 2. صفحة إنشاء حساب جديد (براها منفصلة)
    public function create(){
        // بجيب بس الموظفين الشغالين وما عندهم حساب
        // لو ما عندك عمود status شيل سطر where
        $employees = Employee::whereDoesntHave('user')
            ->when(true, function($q){
                // حاول تفلتر المتوفين والعمال المؤقتين
                if (\Schema::hasColumn('employees', 'status')) {
                    return $q->whereNotIn('status', ['deceased', 'dead', 'متوفي']);
                }
                return $q;
            })
            ->get();

        return view('users.create', compact('employees'));
    }

    // 3. حفظ الحساب الجديد
    public function store(Request $request){
        $request->validate([
            'employee_id' => 'required|exists:employees,id|unique:users,employee_id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,employee,manager',
        ],[
            'employee_id.unique' => 'الموظف ده عندو حساب أصلاً',
            'email.unique' => 'الإيميل ده مستخدم قبل كده',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        User::create([
            'name' => $employee->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'employee_id' => $employee->id,
        ]);

        return redirect()->route('users.index')->with('success', 'تم إنشاء حساب لـ: '.$employee->name);
    }

    // 4. تعديل حساب
    public function edit(User $user){
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user){
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required',
            'password' => 'nullable|min:6|confirmed'
        ]);

        $user->email = $request->email;
        $user->role = $request->role;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('users.index')->with('success','تم التعديل');
    }

    // 5. حذف حساب (ما بحذف سجل الموظف)
    public function destroy(User $user){
        // ما تخلي المدير يحذف نفسو
        if($user->id == auth()->id()){
            return back()->with('error','ما ممكن تحذف حسابك الحالي');
        }
        $user->delete();
        return back()->with('success','تم حذف الحساب، سجل الموظف ما زال موجود');
    }
}
