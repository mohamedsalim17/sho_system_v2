<?php
namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SystemSettingsController extends Controller
{
    public function index()
    {
        return view('system-settings.index', [
            'company' => Company::first(),
            'users' => User::with('employee')->latest()->limit(100)->get(),
            'logs' => DB::table('login_logs')
                ->join('users', 'users.id', '=', 'login_logs.user_id')
                ->select('users.name', 'login_logs.login_at', 'login_logs.ip_address')
                ->latest('login_at')
                ->limit(50)
                ->get(),
        ]);
    }

    public function storeCompany(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'tax_number' => ['nullable', 'string', 'max:100'],
        ]);
        Company::firstOrCreate(['id' => 1])->update($data);

        return back()->with('success', 'تم حفظ بيانات الشركة.');
    }

    public function storeLogo(Request $request)
    {
        $data = $request->validate([
            'logo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
        $path = $data['logo']->store('logos', 'public');
        Company::firstOrCreate(['id' => 1])->update(['logo' => $path]);

        return back()->with('success', 'تم تحديث الشعار.');
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'hr', 'viewer'])],
        ]);
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        return back()->with('success', 'تم إنشاء المستخدم.');
    }

    public function deleteUser(int $id)
    {
        $user = User::findOrFail($id);
        if ($user->is(auth()->user())) {
            return back()->with('error', 'لا يمكنك حذف الحساب المستخدم حاليًا.');
        }
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'لا يمكن حذف المدير الأخير في النظام.');
        }

        $user->delete();

        return back()->with('success', 'تم حذف الحساب.');
    }

    public function downloadBackup()
    {
        if (DB::connection()->getDriverName() !== 'sqlite') {
            abort(501, 'تنزيل النسخة الاحتياطية متاح حاليًا عند استخدام قاعدة SQLite المحلية فقط.');
        }

        $databasePath = config('database.connections.'.config('database.default').'.database');
        if (!$databasePath || $databasePath === ':memory:' || !File::exists($databasePath)) {
            abort(404, 'ملف قاعدة البيانات المحلية غير متاح لإنشاء نسخة احتياطية.');
        }

        $directory = storage_path('app/backups');
        File::ensureDirectoryExists($directory);
        $backupPath = $directory.DIRECTORY_SEPARATOR.'backup_'.Str::uuid().'.sqlite';
        $quotedPath = str_replace("'", "''", $backupPath);

        try {
            DB::statement("VACUUM INTO '{$quotedPath}'");
        } catch (\Throwable $exception) {
            File::delete($backupPath);
            throw $exception;
        }

        return response()->streamDownload(function () use ($backupPath) {
            try {
                $stream = fopen($backupPath, 'rb');
                if ($stream === false) {
                    throw new \RuntimeException('تعذر فتح نسخة قاعدة البيانات.');
                }
                fpassthru($stream);
                fclose($stream);
            } finally {
                File::delete($backupPath);
            }
        }, 'backup_'.now()->format('Y-m-d_His').'.sqlite', [
            'Content-Type' => 'application/vnd.sqlite3',
        ]);
    }

    public function clean()
    {
        Artisan::call('optimize:clear');
        return back()->with('success', 'تم تنظيف ملفات التخزين المؤقت المحلية.');
    }

    // للمستقبل: ضيف هنا أي دالة جديدة وما تهبش الفوق
    // public function storeX() {}
}
