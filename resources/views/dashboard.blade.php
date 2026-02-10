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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white p-5 rounded-xl shadow">
            <div class="flex justify-between">
                <div>
                    <div class="text-gray-500 text-sm">Total Produk</div>
                    <div class="text-3xl font-bold">{{ $totalProducts }}</div>
                </div>
                <div class="text-3xl">📦</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <div class="flex justify-between">
                <div>
                    <div class="text-gray-500 text-sm">Stok Kritis</div>
                    <div class="text-3xl font-bold text-red-600">
                        {{ $lowStockCount }}
                    </div>
                </div>
                <div class="text-3xl">⚠️</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <div class="flex justify-between">
                <div>
                    <div class="text-gray-500 text-sm">Produk Arsip</div>
                    <div class="text-3xl font-bold">
                        {{ $archivedProducts }}
                    </div>
                </div>
                <div class="text-3xl">🗄️</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <div class="flex justify-between">
                <div>
                    <div class="text-gray-500 text-sm">Nilai Stok</div>
                    <div class="text-xl font-bold">
                        Rp {{ number_format($stockValue ?? 0) }}
                    </div>
                </div>
                <div class="text-3xl">💰</div>
            </div>
        </div>

    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Bar -->
        <div class="bg-white p-4 rounded-xl shadow">
            <h3 class="font-semibold mb-2 text-sm">
                Stok Masuk vs Keluar
            </h3>
            <div class="h-56">
                <canvas id="stockChart"></canvas>
            </div>
        </div>

        <!-- Line -->
        <div class="bg-white p-4 rounded-xl shadow">
            <h3 class="font-semibold mb-2 text-sm">
                Stok per Bulan
            </h3>
            <div class="h-56">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <!-- Donut -->
        <div class="bg-white p-4 rounded-xl shadow lg:col-span-2">
            <h3 class="font-semibold mb-2 text-sm">
                Produk per Kategori
            </h3>
            <div class="h-56">
                <canvas id="categoryDonut"></canvas>
            </div>
        </div>

    </div>

    <!-- Recent Activity -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="font-bold mb-4">Aktivitas Stok Terbaru</h3>

        <div class="overflow-x-auto">
            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">Produk</th>
                        <th class="p-2 border">Tipe</th>
                        <th class="p-2 border">Qty</th>
                        <th class="p-2 border">User</th>
                        <th class="p-2 border">Waktu</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($recentLogs as $log)
                    <tr>
                        <td class="p-2 border">
                            {{ $log->product->name ?? '-' }}
                        </td>

                        <td class="p-2 border">
                            @if($log->type=='in')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
                                    in
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded">
                                    out
                                </span>
                            @endif
                        </td>

                        <td class="p-2 border font-semibold">
                            {{ $log->qty_change }}
                        </td>

                        <td class="p-2 border">
                            {{ $log->user->name ?? '-' }}
                        </td>

                        <td class="p-2 border text-gray-500">
                            {{ $log->created_at->format('d M Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-400">
                            Belum ada aktivitas
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ================== CHART JS ================== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const stockIn = {{ $stockStats['in'] ?? 0 }};
const stockOut = {{ $stockStats['out'] ?? 0 }};

new Chart(document.getElementById('stockChart'), {
    type: 'bar',
    data: {
        labels: ['Masuk','Keluar'],
        datasets: [{
            data: [stockIn, stockOut]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins:{legend:{display:false}}
    }
});

// monthly
const monthlyLabels = {!! json_encode($monthlyStats->pluck('month')) !!};
const monthlyIn = {!! json_encode($monthlyStats->pluck('total_in')) !!};
const monthlyOut = {!! json_encode($monthlyStats->pluck('total_out')) !!};

new Chart(document.getElementById('monthlyChart'), {
    type: 'line',
    data: {
        labels: monthlyLabels,
        datasets: [
            {label:'Masuk', data: monthlyIn, tension:.3},
            {label:'Keluar', data: monthlyOut, tension:.3}
        ]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false
    }
});

// donut
const catLabels = {!! json_encode($categoryStats->keys()) !!};
const catTotals = {!! json_encode($categoryStats->values()) !!};

new Chart(document.getElementById('categoryDonut'), {
    type: 'doughnut',
    data: {
        labels: catLabels,
        datasets: [{data: catTotals}]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        plugins:{legend:{position:'bottom'}}
    }
});
</script>

@endsection
