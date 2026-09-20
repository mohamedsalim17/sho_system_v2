@extends('layouts.app')

@section('content')
<div class="container">
    <h1>قائمة العملاء</h1>
    <a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">+ اضافة عميل جديد</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>الهاتف</th>
                <th>العنوان</th>
                <th> العمليات </th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
            <tr>
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->address }}</td>
                <td>
                <a href="{{ route('customers.edit', customer->id) }}" class "btn-warning" </button>style="padding:5px 10px; background:blue; color:white; text-decoration:none;">تعديل</a>
    
                 <form action="{{ route('customers.destroy', customer->id) }}" method="POST" style="display:inline;">
                @csrf
                 @method('DELETE')
               <button type="submit" onclick="return confirm('متأكد عايز تحذف؟')" style="padding:5px 10px; background:red; color:white; border:none;">حذف</button>
               </form>
               </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">لا يوجد عملاء بعد</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
