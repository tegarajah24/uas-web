<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold">Riwayat Transaksi</h2>
        <input type="date" class="input input-bordered input-sm" wire:model.live="filterDate">
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pasien</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->id }}</td>
                        <td>{{ $invoice->patient->name }}</td>
                        <td>Rp {{ number_format($invoice->total, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $invoice->status === 'paid' ? 'badge-success' : 'badge-warning' }}">
                                {{ $invoice->status === 'paid' ? 'Lunas' : 'Pending' }}
                            </span>
                        </td>
                        <td>{{ $invoice->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <details class="dropdown">
                                <summary class="btn btn-xs btn-soft">Rincian</summary>
                                <div class="dropdown-content bg-base-100 rounded-box p-4 shadow w-80 z-50">
                                    <table class="table table-xs">
                                        @foreach ($invoice->items as $item)
                                            <tr>
                                                <td>{{ $item->description }}</td>
                                                <td class="text-right">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="font-bold">
                                            <td>Total</td>
                                            <td class="text-right">Rp {{ number_format($invoice->total, 0, ',', '.') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </details>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-base-content/50 py-8">Belum ada transaksi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
