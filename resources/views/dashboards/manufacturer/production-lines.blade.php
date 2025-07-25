@extends('layouts.dashboard')

@section('title', 'Manufacturer Production Lines')

@section('sidebar-content')
    @include('dashboards.manufacturer.sidebar')
@endsection

@section('content')
<div class="content-card">
    <div class="products-header-row" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 class="page-title" style="color: var(--text); font-size: 2rem; font-weight: bold; margin-bottom: 0.2rem;"><i class="fas fa-cogs"></i> Production Lines</h2>
        <button class="button add-product-btn" onclick="showAddLineModal()">+ Add Production Line</button>
    </div>

    <div class="table-section">
        <h4 style="color: var(--primary); margin-bottom: 1rem;">Active Production Lines</h4>
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th style="color: #333;">Line Name</th>
                    <th style="color: #333;">Assigned Item</th>
                    <th style="color: #334;">Current Stage</th>
                    <th style="color: #333;">Status</th>
                    <th style="color: #333;">Throughput (units/hr)</th>
                    <th style="color: #333;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productionLines as $line)
                <tr>
                    <td>{{ $line->name }}</td>
                    <td>
                        @if($line->product)
                            Product: {{ $line->product->name }}
                        @elseif($line->retailerOrder)
                            Order #{{ $line->retailerOrder->id }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('manufacturer.production-lines.update', $line->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="name" value="{{ $line->name }}">
                            <input type="hidden" name="throughput" value="{{ $line->throughput }}">
                            <input type="hidden" name="status" value="{{ $line->status }}">
                            <select name="current_stage" onchange="this.form.submit()">
                                <option value="raw_material" {{ $line->current_stage == 'raw_material' ? 'selected' : '' }}>Raw Material</option>
                                <option value="assembling" {{ $line->current_stage == 'assembling' ? 'selected' : '' }}>Assembling</option>
                                <option value="painting" {{ $line->current_stage == 'painting' ? 'selected' : '' }}>Painting</option>
                                <option value="quality_control" {{ $line->current_stage == 'quality_control' ? 'selected' : '' }}>Quality Control</option>
                                <option value="completed" {{ $line->current_stage == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="failed" {{ $line->current_stage == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                            @if($line->current_stage == 'failed')
                                <input type="text" name="failed_reason" placeholder="Reason for failure" value="{{ $line->failed_reason }}" onchange="this.form.submit()">
                            @endif
                        </form>
                    </td>
                    <td><span class="badge badge-{{ $line->status == 'active' ? 'success' : 'warning' }}">{{ ucfirst($line->status) }}</span></td>
                    <td>{{ $line->throughput }}</td>
                    <td>
                        <button class="button action-btn edit-btn" onclick="showEditLineModal({{ $line->id }}, '{{ $line->name }}', {{ $line->product_id ?? 'null' }}, {{ $line->retailer_order_id ?? 'null' }}, '{{ $line->throughput }}', '{{ $line->status }}')"><i class="fas fa-edit"></i> Edit</button>
                        <form action="{{ route('manufacturer.production-lines.destroy', $line->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="button action-btn delete-btn" onclick="return confirm('Delete this production line?')"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="addLineModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); z-index:9999; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:10px; max-width:500px; padding:2rem; position:relative;">
            <button onclick="hideAddLineModal()" style="position:absolute; top:10px; right:15px; background:none; border:none; font-size:1.5rem; color:#888; cursor:pointer;">&times;</button>
            <h3>Add New Production Line</h3>
            <form action="{{ route('manufacturer.production-lines.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="line_name">Line Name</label>
                    <input type="text" id="line_name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="product_id">Assign Product</label>
                    <select name="product_id" class="form-control">
                        <option value="">None</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="retailer_order_id">Assign Retailer Order</label>
                    <select name="retailer_order_id" class="form-control">
                        <option value="">None</option>
                        @foreach($retailerOrders as $order)
                            <option value="{{ $order->id }}">Order #{{ $order->id }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="throughput">Throughput (units/hr)</label>
                    <input type="number" id="throughput" name="throughput" class="form-control" required>
                </div>
                <button type="submit" class="button add-product-btn">Save Production Line</button>
            </form>
        </div>
    </div>

    <div id="editLineModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); z-index:9999; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:10px; max-width:500px; padding:2rem; position:relative;">
            <button onclick="hideEditLineModal()" style="position:absolute; top:10px; right:15px; background:none; border:none; font-size:1.5rem; color:#888; cursor:pointer;">&times;</button>
            <h3>Edit Production Line</h3>
            <form id="editLineForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="edit_line_name">Line Name</label>
                    <input type="text" id="edit_line_name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit_product_id">Assign Product</label>
                    <select id="edit_product_id" name="product_id" class="form-control">
                        <option value="">None</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_retailer_order_id">Assign Retailer Order</label>
                    <select id="edit_retailer_order_id" name="retailer_order_id" class="form-control">
                        <option value="">None</option>
                        @foreach($retailerOrders as $order)
                            <option value="{{ $order->id }}">Order #{{ $order->id }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_throughput">Throughput (units/hr)</label>
                    <input type="number" id="edit_throughput" name="throughput" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit_status">Status</label>
                    <select id="edit_status" name="status" class="form-control" required>
                        <option value="active">Active</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <button type="submit" class="button add-product-btn">Update Production Line</button>
            </form>
        </div>
    </div>
</div>

<script>
function showAddLineModal() {
    document.getElementById('addLineModal').style.display = 'flex';
}

function hideAddLineModal() {
    document.getElementById('addLineModal').style.display = 'none';
}

function showEditLineModal(id, name, product_id, retailer_order_id, throughput, status) {
    document.getElementById('editLineForm').action = '/manufacturer/production-lines/' + id;
    document.getElementById('edit_line_name').value = name;
    document.getElementById('edit_product_id').value = product_id;
    document.getElementById('edit_retailer_order_id').value = retailer_order_id;
    document.getElementById('edit_throughput').value = throughput;
    document.getElementById('edit_status').value = status;
    document.getElementById('editLineModal').style.display = 'flex';
}

function hideEditLineModal() {
    document.getElementById('editLineModal').style.display = 'none';
}
</script>
@endsection
