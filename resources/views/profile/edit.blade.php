@extends('layouts.app')
@section('title', 'حسابي')
@section('content')
<main class="form-page">
    <header class="form-page-heading"><div><h1>إعدادات الحساب</h1><p>حدّث بياناتك وكلمة المرور أو احذف حسابك بعد التأكيد.</p></div></header>
    <div class="profile-sections">
        <section class="form-card">@include('profile.partials.update-profile-information-form')</section>
        <section class="form-card">@include('profile.partials.update-password-form')</section>
        <section class="form-card">@include('profile.partials.delete-user-form')</section>
    </div>
</main>
@endsection
