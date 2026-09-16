<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>كل الموظفين</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">قائمة الموظفين</h2>
    <a href="{{ route('employees.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ اضافة موظف جديد</a>
    
    <table class="w-full bg-white rounded shadow">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">#</th>
                <th class="p-2">الاسم</th>
                <th class="p-2">الوظيفة</th>
                <th class="p-2">عدد الاقارب</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $emp)
            <tr class="border-b">
                <td class="p-2">{{ $emp->id }}</td>
                <td class="p-2">{{ $emp->name }}</td>
                <td class="p-2">{{ $emp->job_title }}</td>
                <td class="p-2">{{ $emp->relatives->count() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
