@extends('layouts.app')

@section('content')
<div class="container">
    <h1>قائمة المنتجات</h1>
    <table class="table">
        <tr><th>الاسم</th><th>السعر</th><th>الكمية</th></tr>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->quantity }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
