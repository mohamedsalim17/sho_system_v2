@extends('layouts.app')
@section('content')
<div class="container py-4" dir="rtl" style="text-align:right">
  <div class="card border-0 shadow rounded-4 overflow-hidden">
    <div class="card-header bg-white border-0 p-4 d-flex justify-content-between align-items-center">
      <h4 class="fw-bold m-0">العملاء ({{ $customers->count() }})</h4>
      <a href="{{ route('customers.create') }}" class="btn btn-dark rounded-pill">+ عميل جديد</a>
    </div>

    <div class="table-responsive">
      <table class="table table-hover mb-0 text-end align-middle">
        <thead class="bg-light"><tr><th class="pe-4">#</th><th>الاسم</th><th>الهاتف</th><th>المدينة</th><th class="text-center">الاجراءات</th></tr></thead>
        <tbody>
        @foreach($customers as $i => $c)
          <tr>
            <td class="pe-4">{{ $i+1 }}</td>
            <td><b>{{ $c->name }}</b><br><small class="text-muted">{{ $c->national_id }}</small></td>
            <td>{{ $c->phone }}</td>
            <td>{{ $c->city }}</td>
            <td class="text-center">
              <button onclick="openDetails({{ $c->id }})" class="btn btn-sm btn-dark rounded-pill px-3">التفاصيل</button>
              <a href="{{ route('customers.edit',$c->id) }}" class="btn btn-sm btn-outline-dark rounded-pill">تعديل</a>
              
              <form action="{{ route('customers.destroy',$c->id) }}" method="POST" style="display:inline" onsubmit="return confirm('متأكد عايز تحذف {{ $c->name }} ؟')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger rounded-pill">حذف</button>
              </form>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>

  {{-- المودالات --}}
  @foreach($customers as $c)
  <div id="box-{{ $c->id }}" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.6); z-index:9999; align-items:center; justify-content:center; padding:15px;">
    <div style="background:#fff; width:100%; max-width:480px; border-radius:20px; padding:20px;" dir="rtl">
      <div class="d-flex justify-content-between mb-3">
        <h5 class="fw-bold">{{ $c->name }}</h5>
        <button onclick="closeDetails({{ $c->id }})" class="btn btn-sm btn-light rounded-circle">✕</button>
      </div>
      <div class="bg-light p-2 rounded-3 mb-2"><b>الجنس:</b> {{ $c->gender ?? '-' }} | <b>التعليم:</b> {{ $c->education_level ?? '-' }}</div>
      <div class="bg-light p-2 rounded-3 mb-2"><b>الوظيفة:</b> {{ $c->job ?? '-' }}</div>
      <div class="bg-light p-2 rounded-3 mb-2"><b>الرقم الوطني:</b> {{ $c->national_id }}</div>
      <div class="bg-light p-2 rounded-3 mb-2"><b>الولاية:</b> {{ $c->state }} - {{ $c->city }}</div>
      <div class="bg-light p-2 rounded-3 mb-3"><b>العنوان:</b> {{ $c->address ?? '-' }}</div>
      <button onclick="closeDetails({{ $c->id }})" class="btn btn-dark w-100 rounded-pill">إغلاق</button>
    </div>
  </div>
  @endforeach

  <script>
    function openDetails(id){ document.getElementById('box-'+id).style.display='flex'; }
    function closeDetails(id){ document.getElementById('box-'+id).style.display='none'; }
  </script>

</div>
@endsection
