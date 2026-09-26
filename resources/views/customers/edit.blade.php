@extends('layouts.app')
@section('content')
<td>
    <a href="{{ route('customers.edit', $customer->id) }}" style="padding:5px 10px; background:blue; color:white; text-decoration:none;">تعديل</a>
    
    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('متأكد عايز تحذف؟')" style="padding:5px 10px; background:red; color:white; border:none;">حذف</button>
    </form>
</td>
 <button type="submit" class="btn btn-primary mt-3">تحديث</button>
            </form>
        </div>
    </div>
</div>
@endsection
