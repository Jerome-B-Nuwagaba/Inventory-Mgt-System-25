<!DOCTYPE html>
<html>
<head>
    <title>Inventory List</title>
</head>
<body>
    <h2>Inventory List</h2>
    <a href="{{ route('inventory.create') }}">Add New Item</a>
    <ul>
        @foreach($items as $item)
            <li>{{ $item->item_name }}: {{ $item->quantity }}</li>
        @endforeach
    </ul>
    <a href="{{ route('dashboard') }}">Back to Dashboard</a>
</body>
</html>