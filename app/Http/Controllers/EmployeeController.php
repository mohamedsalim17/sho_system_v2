<?php
namespace App\Http\Controllers;
use App\Models\Employee; use Illuminate\Http\Request;
class EmployeeController extends Controller{
 public function index(){ $employees=Employee::latest()->paginate(20); return view('employees.index',compact('employees')); }
 public function create(){ return view('employees.create'); }
 public function store(Request $r){ Employee::create($r->all()); return redirect('/employees'); }
 public function edit(Employee $employee){ return view('employees.edit',compact('employee')); }
 public function update(Request $r, Employee $employee){ $employee->update($r->all()); return redirect('/employees'); }
 public function destroy(Employee $employee){ $employee->delete(); return back(); }
}