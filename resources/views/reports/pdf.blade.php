<!DOCTYPE html>
<html dir="rtl"><head><meta charset="utf-8">
<style>body{font-family:DejaVu Sans; font-size:11px} table{width:100%;border-collapse:collapse} th,td{border:1px solid #000;padding:4px} h3{text-align:center}</style>
</head><body>
<h3>تقرير الموظفين - {{ date('Y-m-d') }}</h3>
<table><thead><tr style="background:#eee">@foreach($selectedColumns as $c)<th>{{ $allColumns[$c] }}</th>@endforeach</tr></thead>
<tbody>@foreach($employees as $e)<tr>@foreach($selectedColumns as $c)<td>{{ $e->$c }}</td>@endforeach</tr>@endforeach</tbody>
</table>
<script>window.print()</script>
</body></html>
