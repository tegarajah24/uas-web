<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold">Resep Masuk</h2>
        <select class="select select-bordered select-sm" wire:model.live="filterStatus">
            <option value="menunggu">Menunggu</option>
            <option value="disiapkan">Disiapkan</option>
            <option value="diserahkan">Diserahkan</option>
            <option value="">Semua</option>
        </select>
    </div>

    <div class="space-y-4">
        @forelse ($this->prescriptions as $prescription)
            <div class="card card-border bg-base-100">
                <div class="card-body">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-semibold">{{ $prescription->medicalRecord->patient->name }}</p>
                            <p class="text-sm text-base-content/60">
                                RM: {{ $prescription->medicalRecord->patient->no_rm }} &middot;
                                Dokter: {{ $prescription->medicalRecord->doctor->name }}
                            </p>
                        </div>
                        @switch($prescription->status)
                            @case('menunggu')
                                <span class="badge badge-warning">Menunggu</span>
                                @break
                            @case('disiapkan')
                                <span class="badge badge-info">Disiapkan</span>
                                @break
                            @case('diserahkan')
                                <span class="badge badge-success">Diserahkan</span>
                                @break
                        @endswitch
                    </div>

                    <div class="overflow-x-auto mt-2">
                        <table class="table table-sm">
                            <thead>
                                <tr><th>Obat</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr>
                            </thead>
                            <tbody>
                                @foreach ($prescription->items as $item)
                                    <tr>
                                        <td>{{ $item->medicine->name }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @error("stock_{$prescription->id}")
                        <span class="text-error text-xs">{{ $message }}</span>
                    @enderror

                    <div class="card-actions mt-2">
                        @if ($prescription->status === 'menunggu')
                            <button class="btn btn-sm btn-primary" wire:click="proses('disiapkan', {{ $prescription->id }})">
                                Siapkan
                            </button>
                        @elseif ($prescription->status === 'disiapkan')
                            <button class="btn btn-sm btn-success" wire:click="proses('diserahkan', {{ $prescription->id }})">
                                Serahkan
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="card card-border bg-base-100">
                <div class="card-body text-center text-base-content/50 py-8">
                    Tidak ada resep dengan status ini
                </div>
            </div>
        @endforelse
    </div>
</div>
