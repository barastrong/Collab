@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="alert alert-success" style="display: none;" id="statusUpdateSuccess">
    Status berhasil diperbarui
</div>
<div class="alert alert-danger" style="display: none;" id="statusUpdateError">
    Terjadi kesalahan saat memperbarui status
</div>

<table>
    <thead>
        <tr>
            <th>Kode Pembelian</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Ukuran</th>
            <th>Harga Satuan</th>
            <th>Total Harga</th>
            <th>Alamat Pengiriman</th>
            <th>No. Telepon</th>
            <th>Status</th>
            <th>Tanggal Pembelian</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($buy as $purchase)
            <tr>
                <td>{{ $purchase->purchase_code }}</td>
                <td>{{ $purchase->barang->nama }}</td>
                <td>{{ $purchase->quantity }}</td>
                <td>{{ $purchase->size }}</td>
                <td>Rp {{ number_format($purchase->price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</td>
                <td>{{ $purchase->shipping_address }}</td>
                <td>{{ $purchase->phone_number }}</td>
                <td>
                    <select name="status" class="form-select status-select" data-purchase-id="{{ $purchase->id }}">
                        <option value="pending" {{ $purchase->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $purchase->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $purchase->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="completed" {{ $purchase->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $purchase->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </td>
                <td>{{ $purchase->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="10">Tidak ada data pembelian</td>
            </tr>
        @endforelse
    </tbody>
</table>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all status select elements
    const statusSelects = document.querySelectorAll('.status-select');

    // Add change event listener to each select
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const purchaseId = this.dataset.purchaseId;
            const newStatus = this.value;
            updateStatus(purchaseId, newStatus, this);
        });
    });

    function updateStatus(purchaseId, status, selectElement) {
        // Show loading state
        selectElement.disabled = true;

        fetch(`/purchases/${purchaseId}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            selectElement.disabled = false;
            if (data.success) {
                const successAlert = document.getElementById('statusUpdateSuccess');
                successAlert.style.display = 'block';
                setTimeout(() => {
                    successAlert.style.display = 'none';
                }, 3000);
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            selectElement.disabled = false;
            const errorAlert = document.getElementById('statusUpdateError');
            errorAlert.style.display = 'block';
            setTimeout(() => {
                errorAlert.style.display = 'none';
            }, 3000);
            // Revert to previous value
            selectElement.value = selectElement.getAttribute('data-previous-value');
        });

        // Store the current value as previous value
        selectElement.setAttribute('data-previous-value', status);
    }
});
</script>
</body>
</html>
@endsection