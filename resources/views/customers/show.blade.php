@extends('layouts.main')
@section('title', 'بيانات العميل')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>{{ $customer->name }}</h1><p>تفاصيل سجل العميل.</p></div>
        <div class="form-actions" style="margin:0"><a class="form-cancel" href="{{ route('customers.index') }}">العودة للعملاء</a>@if(in_array(auth()->user()->role, ['admin', 'hr'], true))<a class="form-submit" href="{{ route('customers.edit', $customer) }}">تعديل</a>@endif</div>
    </header>
    <section class="form-card">
        <div class="report-grid">
            @foreach(['الهاتف' => $customer->phone, 'الرقم الوطني' => $customer->national_id, 'الجنس' => $customer->gender, 'تاريخ الميلاد' => $customer->birth_date, 'الولاية' => $customer->state, 'المدينة' => $customer->city, 'التعليم' => $customer->education_level, 'الوظيفة' => $customer->job, 'تاريخ الوفاة' => $customer->date_of_death, 'مكان الوفاة' => $customer->place_of_death, 'العنوان' => $customer->address] as $label => $value)
                <div class="report-stat"><span>{{ $label }}</span><strong>{{ $value ?: '-' }}</strong></div>
            @endforeach
        </div>
    </section>
</main>
@endsection
