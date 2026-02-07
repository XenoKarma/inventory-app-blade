@extends('layouts.app')

@section('title', 'Dashboard Inventory')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800">
            Dashboard Inventory
        </h2>
        <span class="text-sm text-gray-500">
            Ringkasan data inventaris
        </span>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-500 text-sm mb-1">
                        Total Produk
                    </div>
                    <div class="text-3xl font-bold tracking-tight">
                        {{ $totalProducts }}
                    </div>
                </div>
                <div class="text-3xl">📦</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-500 text-sm mb-1">
                        Stok Kritis
                    </div>
                    <div class="text-3xl font-bold text-red-600 tracking-tight">
                        {{ $lowStockCount }}
                    </div>
                </div>
                <div class="text-3xl">⚠️</div>
            </div>
        </div>

    </div>

    <!-- Recent Activity -->
    <div class="bg-white p-6 rounded-xl shadow">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-lg">
                Aktivitas Stok Terbaru
            </h3>
            <span class="text-sm text-gray-400">
                Log perubahan stok
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-sm">
                        <th class="p-3 border">Produk</th>
                        <th class="p-3 border">Tipe</th>
                        <th class="p-3 border">Qty</th>
                        <th class="p-3 border">User</th>
                        <th class="p-3 border">Waktu</th>
                    </tr>
                </thead>

                <tbody class="text-sm">

                @forelse($recentLogs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border">
                            {{ $log->product->name ?? '-' }}
                        </td>

                        <td class="p-3 border">
                            @if($log->type == 'in')
                                <span class="px-2 py-1 rounded-md bg-green-100 text-green-700">
                                    {{ $log->type }}
                                </span>
                            @elseif($log->type == 'out')
                                <span class="px-2 py-1 rounded-md bg-red-100 text-red-700">
                                    {{ $log->type }}
                                </span>
                            @else
                                <span class="px-2 py-1 rounded-md bg-gray-100">
                                    {{ $log->type }}
                                </span>
                            @endif
                        </td>

                        <td class="p-3 border font-semibold">
                            {{ $log->qty_change }}
                        </td>

                        <td class="p-3 border">
                            {{ $log->user->name ?? '-' }}
                        </td>

                        <td class="p-3 border text-gray-500">
                            {{ $log->created_at->format('d M Y H:i') }}
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-400">
                            Belum ada aktivitas stok
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
