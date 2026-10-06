<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head><meta charset="UTF-8"><title>التقارير</title>
<style>
*{font-family:Tahoma;box-sizing:border-box}body{background:#f4f6f9;margin:0;padding:15px;direction:rtl}
.top{display:flex;justify-content:space-between;align-items:center;margin-bottom:15px}
.btn{padding:10px 16px;border-radius:8px;font-weight:bold;text-decoration:none;display:inline-block;border:none;cursor:pointer}
.btn-d{background:#222;color:#fff}.btn-light{background:#eee;color:#000}
.card{background:#fff;border-radius:12px;padding:15px;margin-bottom:12px;box-shadow:0 2px 5px #0001}

/* السلايد */
#reportsSlide{position:fixed;top:0;right:-400px;width:350px;height:100%;background:#fff;box-shadow:-3px 0 15px #0003;transition:0.3s;z-index:9999;padding:20px;overflow:auto}
#reportsSlide.active{right:0}
.overlay{position:fixed;top:0;left:0;width:100%;height:100%;background:#0005;display:none;z-index:9998}
.overlay.active{display:block}
.slide-btn{display:block;width:100%;padding:15px;margin:10px 0;border-radius:10px;border:none;font-weight:bold;font-size:15px;cursor:pointer;text-align:right}
.slide-btn span{display:block;font-size:11px;color:#666;font-weight:normal;margin-top:4px}
</style>
</head>
<body>

<div class="top">
<h2>التقارير</h2>
<div style="display:flex;gap:8px">
<button onclick="openSlide()" class="btn btn-d">📊 فتح سلايد التقارير</button>
<a href="{{ url('/') }}" class="btn btn-light">داش بورد</a>
</div>
</div>

<div class="card" style="text-align:center;color:#888">
دوس زر <b>فتح سلايد التقارير</b> - حايفتح ليك السلايد فيهو 3 تقارير
</div>

{{-- الخلفية --}}
<div id="overlay" class="overlay" onclick="closeSlide()"></div>

{{-- السلايد نفسه --}}
<div id="reportsSlide">
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
<h3 style="margin:0">📑 التقارير</h3>
<button onclick="closeSlide()" style="background:#eee;border:none;padding:8px 12px;border-radius:50%;cursor:pointer;font-weight:bold">X</button>
</div>

<button class="slide-btn" style="background:#e8f5e9;color:#2e7d32" onclick="window.location.href='{{ url('/reports/general') }}'">
📄 تقرير عام
<span>كل الموظفين بكل الحقول - طباعة A4 صفحتين</span>
</button>

<button class="slide-btn" style="background:#e3f2fd;color:#1565c0" onclick="window.location.href='{{ url('/reports/custom') }}'">
🧩 تقرير مخصص
<span>تختار الحقول العايزها انت (4 حقول واكثر)</span>
</button>

<button class="slide-btn" style="background:#fff3e0;color:#ef6c00" onclick="window.location.href='{{ url('/reports/builder') }}'">
🔍 تقرير مفلتر + بحث
<span>فيهو اختيار الحقول + فلتر لكل عمود + بحث شغال</span>
</button>

<hr style="margin:20px 0">

<button class="slide-btn" style="background:#222;color:#fff" onclick="window.location.href='{{ url('/') }}'">
🏠 رجوع للداش بورد
</button>
</div>

<script>
function openSlide(){document.getElementById('reportsSlide').classList.add('active');document.getElementById('overlay').classList.add('active');}
function closeSlide(){document.getElementById('reportsSlide').classList.remove('active');document.getElementById('overlay').classList.remove('active');}
</script>

</body></html>
