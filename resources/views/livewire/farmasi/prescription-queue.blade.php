<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Resep Masuk</h2>
        <select class="rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model.live="filterStatus">
            <option value="menunggu">Menunggu</option>
            <option value="disiapkan">Disiapkan</option>
            <option value="diserahkan">Diserahkan</option>
            <option value="">Semua</option>
        </select>
    </div>

    <div class="space-y-4">
        @forelse ($this->prescriptions as $prescription)
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <p class="font-semibold text-gray-900">{{ $prescription->medicalRecord->patient->name }}</p>
                        <p class="text-sm text-gray-500">
                            RM: {{ $prescription->medicalRecord->patient->no_rm }} &middot;
                            Dokter: {{ $prescription->medicalRecord->doctor->name }}
                        </p>
                    </div>
                    @if ($prescription->status === 'menunggu')
                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">Menunggu</span>
                    @elseif ($prescription->status === 'disiapkan')
                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">Disiapkan</span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Diserahkan</span>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="py-2 pr-4 font-medium text-gray-500">Obat</th>
                                <th class="py-2 pr-4 font-medium text-gray-500">Qty</th>
                                <th class="py-2 pr-4 font-medium text-gray-500">Harga</th>
                                <th class="py-2 pr-4 font-medium text-gray-500">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prescription->items as $item)
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 pr-4 text-gray-900">{{ $item->medicine->name }}</td>
                                    <td class="py-2 pr-4 text-gray-700">{{ $item->qty }}</td>
                                    <td class="py-2 pr-4 text-gray-700">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="py-2 pr-4 text-gray-700">Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @error("stock_{$prescription->id}")
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror

                <div class="flex gap-2 mt-4">
                    @if ($prescription->status === 'menunggu')
                        <button class="inline-flex items-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover transition-colors" wire:click="proses('disiapkan', {{ $prescription->id }})">
                            Siapkan
                        </button>
                    @elseif ($prescription->status === 'disiapkan')
                        <button class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors" wire:click="proses('diserahkan', {{ $prescription->id }})">
                            Serahkan
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="rounded-xl border border-gray-200 bg-white p-8 text-center text-gray-400">
                Tidak ada resep dengan status ini
            </div>
        @endforelse
    </div>
</div>
