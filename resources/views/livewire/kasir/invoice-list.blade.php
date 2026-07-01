<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Riwayat Transaksi</h2>
        <input type="date" class="rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model.live="filterDate">
    </div>

    <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                    <th class="px-4 py-3 font-medium text-gray-500">#</th>
                    <th class="px-4 py-3 font-medium text-gray-500">Pasien</th>
                    <th class="px-4 py-3 font-medium text-gray-500">Total</th>
                    <th class="px-4 py-3 font-medium text-gray-500">Status</th>
                    <th class="px-4 py-3 font-medium text-gray-500">Tanggal</th>
                    <th class="px-4 py-3 font-medium text-gray-500">Rincian</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->invoices as $invoice)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-900 font-medium">{{ $invoice->id }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $invoice->patient->name }}</td>
                        <td class="px-4 py-3 text-gray-900 font-medium">Rp {{ number_format($invoice->total, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            @if ($invoice->status === 'paid')
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Lunas</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">Pending</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $invoice->created_at->format('d M Y H:i') }}</td>
                        <td class="px-4 py-3">
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="rounded border border-gray-300 bg-white px-2.5 py-1 text-xs font-medium text-gray-700 hover:bg-gray-50">Rincian</button>
                                <div x-show="open" @click.outside="open = false" class="absolute left-0 mt-1 w-72 rounded-xl border border-gray-200 bg-white p-4 shadow-lg z-50" style="display: none;">
                                    <table class="w-full text-xs">
                                        @foreach ($invoice->items as $item)
                                            <tr>
                                                <td class="py-1 pr-2 text-gray-600">{{ $item->description }}</td>
                                                <td class="py-1 text-right font-medium text-gray-900">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="border-t border-gray-200">
                                            <td class="py-1 pr-2 font-bold text-gray-900">Total</td>
                                            <td class="py-1 text-right font-bold text-gray-900">Rp {{ number_format($invoice->total, 0, ',', '.') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
