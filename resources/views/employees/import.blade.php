@extends('layouts.main')
@section('title', 'استيراد الموظفين')
@section('content')
<main class="form-page">
    <header class="form-page-heading">
        <div><h1>استيراد الموظفين</h1><p>أضف سجلات من ملف محلي مع الاحتفاظ بجميع البيانات الموجودة.</p></div>
        <a class="form-cancel" href="{{ route('employees.index') }}">العودة للموظفين</a>
    </header>
    <section class="form-card">
        <form method="POST" action="{{ route('employees.import') }}" enctype="multipart/form-data">
            @csrf
            <div class="field">
                <label for="employee-file">ملف Excel أو CSV</label>
                <input id="employee-file" name="file" type="file" accept=".xlsx,.xls,.csv" required>
                <small class="form-note">الحد الأقصى 10 ميغابايت. يتجاهل النظام الصف الأول للعناوين. الاسم في العمود C مطلوب؛ الرقم الوظيفي في A اختياري ويُنشأ تلقائيًا عند غيابه. الأعمدة الأخرى اختيارية وفق قالب الاستيراد المحلي.</small>
                @error('file')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-actions"><button class="form-submit" type="submit">استيراد البيانات</button><a class="form-cancel" href="{{ route('employees.index') }}">إلغاء</a></div>
        </form>
    </section>
</main>
@endsection
