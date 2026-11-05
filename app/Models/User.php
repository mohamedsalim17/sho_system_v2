<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['name','email','password','role','last_login_at','login_count'];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['last_login_at'=>'datetime','email_verified_at'=>'datetime'];
    public function employee(){ return $this->belongsTo(Employee::class); }
}
