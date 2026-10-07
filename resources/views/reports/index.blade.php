@extends('layouts.app')
@section('content')
<div class="p-6">
<div class="flex gap-2 mb-6">
<a href="{{route('dashboard')}}" class="bg-gray-800 text-white px-4 py-2 rounded">رجوع للدشبورد</a>
</div>
<div class="grid grid-cols-3 gap-4">
<a href="{{route('reports.general')}}" class="bg-blue-600 text-white p-6 rounded-lg text-center hover:bg-blue-700">تقرير عام</a>
<a href="{{route('reports.custom')}}" class="bg-green-600 text-white p-6 rounded-lg text-center hover:bg-green-700">تقرير مخصص</a>
<a href="{{route('reports.builder')}}" class="bg-purple-600 text-white p-6 rounded-lg text-center hover:bg-purple-700">بحث مفلتر + بناء</a>
</div>
</div>
@endsection
