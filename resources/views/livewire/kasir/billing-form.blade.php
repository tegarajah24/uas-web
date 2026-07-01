<div class="max-w-6xl mx-auto space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Pembayaran</h2>

    <div class="space-y-4">
        @forelse ($this->queuedRecords as $record)
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <p class="text-lg font-bold text-gray-900">{{ $record->patient->name }}</p>
                        <p class="text-sm text-gray-500">RM: {{ $record->patient->no_rm }}</p>
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

                <hr class="border-t border-gray-200 my-4">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Biaya Tindakan</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($record->action_cost, 0, ',', '.') }}</span>
                    </div>
                    @foreach ($record->prescriptions as $prescription)
                        @foreach ($prescription->items as $item)
                            <div class="flex justify-between text-gray-500">
                                <span>{{ $item->medicine->name }} ({{ $item->qty }}x)</span>
                                <span>Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    @endforeach
                    <hr class="border-t border-gray-200 mt-3">
                    <div class="flex justify-between text-lg font-bold text-gray-900 pt-1">
                        <span>Total</span>
                        <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button class="mt-4 w-full inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-white hover:bg-primary-hover transition-colors"
                        wire:click="selectRecord({{ $record->id }})"
                        onclick="document.getElementById('bayar_{{ $record->id }}').showModal()">
                    Bayar Sekarang
                </button>
            </div>

            <dialog id="bayar_{{ $record->id }}" class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center" style="display: none;">
                <div class="bg-white rounded-xl p-6 max-w-sm w-full mx-4 shadow-xl">
                    <h3 class="text-lg font-bold text-gray-900">Konfirmasi Pembayaran</h3>
                    <p class="text-sm text-gray-600 mt-2">Pilih metode pembayaran untuk pasien <strong>{{ $record->patient->name }}</strong></p>
                    <div class="mt-4 space-y-2">
                        <label class="flex items-center gap-3 rounded-lg border border-gray-200 p-3 cursor-pointer hover:bg-gray-50 transition-colors has-[:checked]:border-primary has-[:checked]:bg-primary-50">
                            <input type="radio" name="payment_{{ $record->id }}" value="tunai" class="text-primary accent-primary"
                                   wire:model="paymentMethod" onclick="document.getElementById('payBtn_{{ $record->id }}').disabled = false">
                            <span class="text-sm font-medium text-gray-900">Tunai</span>
                        </label>
                        <label class="flex items-center gap-3 rounded-lg border border-gray-200 p-3 cursor-pointer hover:bg-gray-50 transition-colors has-[:checked]:border-primary has-[:checked]:bg-primary-50">
                            <input type="radio" name="payment_{{ $record->id }}" value="kartu_kredit" class="text-primary accent-primary"
                                   wire:model="paymentMethod" onclick="document.getElementById('payBtn_{{ $record->id }}').disabled = false">
                            <span class="text-sm font-medium text-gray-900">Kartu Kredit</span>
                        </label>
                        <label class="flex items-center gap-3 rounded-lg border border-gray-200 p-3 cursor-pointer hover:bg-gray-50 transition-colors has-[:checked]:border-primary has-[:checked]:bg-primary-50">
                            <input type="radio" name="payment_{{ $record->id }}" value="qris" class="text-primary accent-primary"
                                   wire:model="paymentMethod" onclick="document.getElementById('payBtn_{{ $record->id }}').disabled = false">
                            <span class="text-sm font-medium text-gray-900">QRIS</span>
                        </label>
                    </div>
                    @error('paymentMethod') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                    <div class="flex justify-end gap-2 mt-6">
                        <button class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors"
                                onclick="document.getElementById('bayar_{{ $record->id }}').close()">Batal</button>
                        <button id="payBtn_{{ $record->id }}" disabled
                                class="inline-flex items-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                wire:click="bayar"
                                onclick="document.getElementById('bayar_{{ $record->id }}').close()">Bayar</button>
                    </div>
                </div>
            </dialog>
        @empty
            <div class="rounded-xl border border-gray-200 bg-white p-8 text-center text-gray-400">
                Tidak ada pasien yang siap dibayar
            </div>
        @endforelse
    </div>
</div>
