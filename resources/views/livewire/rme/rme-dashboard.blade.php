<div class="max-w-6xl mx-auto space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Rekam Medis Elektronik</h2>

    <div class="flex flex-wrap gap-2">
        @forelse ($this->queues as $queue)
            <button class="px-3 py-2 text-sm font-medium rounded-lg border transition-colors
                          {{ $selectedQueueId === $queue->id ? 'bg-primary text-white border-primary' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}"
                    wire:click="selectQueue({{ $queue->id }})">
                #{{ $queue->queue_number }}
                <span class="opacity-70 ml-1">{{ $queue->patient->name }}</span>
            </button>
        @empty
            <p class="text-gray-400 text-sm">Tidak ada antrian pasien</p>
        @endforelse
    </div>

    @if ($this->selectedQueue)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1 space-y-4">
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Pasien</h3>
                    <div class="text-sm space-y-1.5">
                        <p><span class="font-medium text-gray-500">RM:</span> <span class="text-gray-900">{{ $this->selectedQueue->patient->no_rm }}</span></p>
                        <p><span class="font-medium text-gray-500">Nama:</span> <span class="text-gray-900">{{ $this->selectedQueue->patient->name }}</span></p>
                        <p><span class="font-medium text-gray-500">NIK:</span> <span class="text-gray-900">{{ $this->selectedQueue->patient->nik }}</span></p>
                        <p><span class="font-medium text-gray-500">Poli:</span> <span class="text-gray-900">{{ ucfirst($this->selectedQueue->poli) }}</span></p>
                    </div>
                </div>

                @if ($this->patientHistory->isNotEmpty())
                    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Riwayat Kunjungan</h3>
                        <div class="space-y-3">
                            @foreach ($this->patientHistory as $record)
                                <div class="text-xs border-b border-gray-100 pb-2 last:border-0 last:pb-0">
                                    <div class="flex items-center gap-1.5 mb-1">
                                        <span class="font-medium text-gray-700">{{ $record->created_at->format('d M Y') }}</span>
                                        @if ($record->id === $savedMedicalRecordId)
                                            <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700">baru</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-500">Diagnosis: {{ $record->diagnosis }}</p>
                                    <p class="text-gray-400">Dokter: {{ $record->doctor->name }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-2 space-y-4">
                @if (!$savedMedicalRecordId)
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Form Pemeriksaan</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Keluhan</label>
                                <textarea class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model="complaint" rows="2"></textarea>
                                @error('complaint') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Diagnosis</label>
                                <textarea class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model="diagnosis" rows="2"></textarea>
                                @error('diagnosis') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Biaya Tindakan (Rp)</label>
                                <input type="number" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model="actionCost" min="0">
                                @error('actionCost') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <button class="mt-4 inline-flex items-center rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-hover transition-colors" wire:click="saveMedicalRecord">
                            Simpan Pemeriksaan
                        </button>
                    </div>
                @else
                    <div class="rounded-xl border border-green-200 bg-green-50 p-5">
                        <div class="flex items-center gap-2 text-green-800">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="font-medium">Pemeriksaan tersimpan</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ $this->savedMedicalRecord->diagnosis }}</p>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Resep Obat</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Obat</label>
                                <select class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model="selectedMedicineId">
                                    <option value="">Pilih obat</option>
                                    @foreach ($this->medicines as $medicine)
                                        <option value="{{ $medicine->id }}">
                                            {{ $medicine->name }} (stok: {{ $medicine->stock }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                                <input type="number" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model="medicineQty" min="1">
                            </div>
                            <button class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors" wire:click="addMedicine">
                                Tambah
                            </button>
                        </div>
                        @error('medicineQty') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror

                        @if (!empty($prescriptionItems))
                            <div class="overflow-x-auto mt-4">
                                <table class="w-full text-left text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-200">
                                            <th class="py-2 pr-4 font-medium text-gray-500">Obat</th>
                                            <th class="py-2 pr-4 font-medium text-gray-500">Qty</th>
                                            <th class="py-2 pr-4 font-medium text-gray-500">Harga</th>
                                            <th class="py-2 pr-4 font-medium text-gray-500">Subtotal</th>
                                            <th class="py-2"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($prescriptionItems as $i => $item)
                                            <tr class="border-b border-gray-100">
                                                <td class="py-2 pr-4 text-gray-900">{{ $item['name'] }}</td>
                                                <td class="py-2 pr-4 text-gray-700">{{ $item['qty'] }}</td>
                                                <td class="py-2 pr-4 text-gray-700">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                                <td class="py-2 pr-4 text-gray-900 font-medium">Rp {{ number_format($item['qty'] * $item['price'], 0, ',', '.') }}</td>
                                                <td class="py-2">
                                                    <button class="text-red-600 hover:text-red-800 text-xs font-medium" wire:click="removeMedicine({{ $i }})">hapus</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <button class="mt-4 w-full inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-white hover:bg-primary-hover transition-colors" wire:click="savePrescription">
                                Simpan Resep & Selesaikan
                            </button>
                        @endif
                        @error('prescriptionItems') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
