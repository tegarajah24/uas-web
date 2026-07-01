<div class="max-w-5xl mx-auto space-y-6">
    <h2 class="text-2xl font-bold">Pembayaran</h2>

    <div class="space-y-4">
        @forelse ($this->queuedRecords as $record)
            <div class="card card-border bg-base-100">
                <div class="card-body">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-bold text-lg">{{ $record->patient->name }}</p>
                            <p class="text-sm text-base-content/60">RM: {{ $record->patient->no_rm }}</p>
                        </div>
                    </div>

                    @php
                        $medicineTotal = 0;
                        foreach ($record->prescriptions as $prescription) {
                            foreach ($prescription->items as $item) {
                                $medicineTotal += $item->qty * $item->price;
                            }
                        }
                        $grandTotal = $record->action_cost + $medicineTotal;
                    @endphp

                    <div class="divider text-sm">Rincian Biaya</div>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span>Biaya Tindakan</span>
                            <span>Rp {{ number_format($record->action_cost, 0, ',', '.') }}</span>
                        </div>
                        @foreach ($record->prescriptions as $prescription)
                            @foreach ($prescription->items as $item)
                                <div class="flex justify-between text-base-content/70">
                                    <span>{{ $item->medicine->name }} ({{ $item->qty }}x)</span>
                                    <span>Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        @endforeach
                        <div class="flex justify-between font-bold text-lg pt-2 border-t">
                            <span>Total</span>
                            <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="card-actions mt-4">
                        <button class="btn btn-primary w-full" wire:click="selectRecord({{ $record->id }})"
                                onclick="document.getElementById('bayar_modal').showModal()">
                            Bayar Sekarang
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="card card-border bg-base-100">
                <div class="card-body text-center text-base-content/50 py-8">
                    Tidak ada pasien yang siap dibayar
                </div>
            </div>
        @endforelse
    </div>

    <dialog id="bayar_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Konfirmasi Pembayaran</h3>
            <p class="py-4">Proses pembayaran untuk pasien ini?</p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-ghost">Batal</button>
                </form>
                <button class="btn btn-primary" wire:click="bayar"
                        onclick="document.getElementById('bayar_modal').close()">
                    Ya, Bayar
                </button>
            </div>
        </div>
    </dialog>
</div>
