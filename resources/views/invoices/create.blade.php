<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>انشاء فاتورة جديدة</title>
    <style> 
        body{font-family:Tahoma; padding:20px; background:#f4f4f4;} 
       .container{background:white; padding:20px; border-radius:8px;}
        select,input{padding:8px; margin:5px; width:200px;} 
        button{background:green; color:white; border:none; padding:10px 20px; cursor:pointer;}
        table{width:100%; border-collapse:collapse; margin-top:15px;}
        th,td{border:1px solid #ddd; padding:8px; text-align:center;}
    </style>
</head>
<body>
    <div class="container">
        <h1>انشاء فاتورة جديدة</h1>

        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf

            <label>اختيار العميل:</label>
            <select name="customer_id" required>
                <option value="">-- اختر عميل --</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
            <br><br>

            <h3>المنتجات</h3>
            <table id="products-table">
                <thead>
                    <tr>
                        <th>المنتج</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="products[0][product_id]">
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->price }} جنيه</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="products[0][quantity]" value="1" min="1"></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <br>
            <button type="submit">حفظ الفاتورة</button>
        </form>

        <br>
        <a href="{{ route('invoices.index') }}">الرجوع لقائمة الفواتير</a>
    </div>
</body>
</html>
