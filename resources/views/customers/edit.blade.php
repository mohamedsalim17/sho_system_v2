<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <title>تعديل عميل</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; width: 50%; margin: auto; }
        input, button { padding: 10px; margin: 5px 0; width: 100%; box-sizing: border-box; }
        button { background: blue; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
<div class="container">
    <h1>تعديل العميل: {{ $customer->name }}</h1>

    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>الاسم:</label>
            <input type="text" name="name" value="{{ old('name', $customer->name) }}" required>
        </div>

        <div>
            <label>الهاتف:</label>
            <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}">
        </div>

        <div>
            <label>الرقم الوطني:</label>
            <input type="text" name="national_id" value="{{ old('national_id', $customer->national_id) }}">
        </div>

        <button type="submit">حفظ التعديل</button>
    </form>
</div>
</body>
</html>
