<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'employee_id', // <--- ده الناقص عشان نربط الحساب بالموظف
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // في لارافيل الجديد بعمل هاش أوتوماتيك
    ];

    // علاقة: الحساب تابع لموظف واحد
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
