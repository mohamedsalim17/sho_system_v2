<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private const ROLES = ['admin', 'hr', 'viewer'];

    public function index()
    {
        $users = User::with('employee')->latest()->paginate(25);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $employees = Employee::whereDoesntHave('user')->orderBy('name')->get();

        return view('users.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required', 'exists:employees,id', 'unique:users,employee_id'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(self::ROLES)],
        ]);
        $employee = Employee::findOrFail($data['employee_id']);

        User::create([
            'name' => $employee->name,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'employee_id' => $employee->id,
        ]);

        return redirect()->route('users.index')->with('success', 'تم إنشاء الحساب وربطه بالموظف.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in(self::ROLES)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($user->is(auth()->user()) && $data['role'] !== 'admin') {
            return back()->withInput()->withErrors(['role' => 'لا يمكن تغيير صلاحية حساب المدير المستخدم حاليًا.']);
        }

        $user->email = $data['email'];
        $user->role = $data['role'];
        if (filled($data['password'] ?? null)) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'تم تحديث الحساب.');
    }

    public function destroy(User $user)
    {
        if ($user->is(auth()->user())) {
            return back()->with('error', 'لا يمكن حذف الحساب المستخدم حاليًا.');
        }
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'لا يمكن حذف المدير الأخير في النظام.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'تم حذف الحساب دون حذف سجل الموظف.');
    }
}
