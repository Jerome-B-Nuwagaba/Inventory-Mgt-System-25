<!DOCTYPE html>
<html>
<head>
    <title>Add Inventory Item</title>
</head>
<body>
    <h2>Add Inventory Item</h2>
    <form method="POST" action="{{ route('inventory.store') }}">
        @csrf
        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" id="item_name" required><br><br>
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" required><br><br>
        <button type="submit">Add Item</button>
    </form>
    <a href="{{ route('inventory.index') }}">Back to Inventory List</a>
</body>
</html>