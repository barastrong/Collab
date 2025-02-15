@extends('layouts.admin')

@section('content')
<div class="container px-6 mx-auto">
    <div class="my-6">
        <h2 class="text-2xl font-semibold text-gray-700">Order Management</h2>
        <p class="text-gray-500 mt-2">Manage and track all customer orders</p>
    </div>

    <!-- Search and Filter Section -->
    <div class="mb-6 flex justify-between items-center">
        <div class="flex-1 max-w-md">
            <form class="flex items-center">
                <input type="text" 
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search by order code..." 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.orders.export') }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                <i class="fas fa-download mr-2"></i>Export Orders
            </a>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Order Info
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Customer
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Amount
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($orders as $order)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full object-cover" 
                                     src="{{ asset('images/' . $order->barang->gambar) }}" 
                                     alt="{{ $order->barang->nama_barang }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $order->purchase_code }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $order->created_at->format('d M Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $order->user->name }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $order->phone_number }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $order->quantity }} item(s)
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" 
                                    onchange="this.form.submit()"
                                    class="text-sm rounded-full px-3 py-1 
                                    @if($order->status == 'completed') bg-green-100 text-green-800
                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.orders.detail', $order) }}" 
                           class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection