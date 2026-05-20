<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>{{ $type }} Item Report</title>
<style>body{font-family:DejaVu Sans,sans-serif;font-size:12px}h1{font-size:20px}table{width:100%;border-collapse:collapse}td,th{border:1px solid #ccc;padding:8px}</style>
</head>
<body>
<h1>{{ $type }} Item Report</h1>
<table>
<tr><th>Title</th><td>{{ $item->title }}</td></tr>
<tr><th>Category</th><td>{{ $item->category->name }}</td></tr>
<tr><th>Status</th><td>{{ $item->status->label() }}</td></tr>
<tr><th>Location</th><td>{{ $item->location }}</td></tr>
<tr><th>Description</th><td>{{ $item->description }}</td></tr>
<tr><th>Verification</th><td>{{ $item->verification_code }}</td></tr>
<tr><th>Reporter</th><td>{{ $item->user->name }}</td></tr>
</table>
</body>
</html>
