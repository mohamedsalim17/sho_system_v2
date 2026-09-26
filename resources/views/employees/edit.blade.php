<h2 style="text-align:center">تعديل الموظف - {{ $employee->name }}</h2>

<form action="{{ route('employees.update', $employee->id) }}" method="POST" style="max-width:700px; margin:20px auto; background:#fff; padding:20px; border-radius:12px; box-shadow:0 2px 10px #ddd">
@csrf
@method('PUT')

@foreach($employee->getAttributes() as $key => $value)
  @if(!in_array($key, ['id','created_at','updated_at']))
    <label style="font-weight:bold; display:block; margin-top:10px">{{ $key }}</label>
    @if($key == 'marital_status')
      <select name="{{ $key }}" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc">
        <option value="أعزب" {{ $value=='أعزب' ? 'selected':'' }}>أعزب</option>
        <option value="متزوج" {{ $value=='متزوج' ? 'selected':'' }}>متزوج</option>
      </select>
    @else
      <input type="text" name="{{ $key }}" value="{{ $value }}" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc">
    @endif
  @endif
@endforeach

<button type="submit" style="width:100%; background:#2C3E5A; color:white; padding:14px; border:none; border-radius:8px; margin-top:20px; font-size:16px">حفظ كل التعديلات</button>
</form>
