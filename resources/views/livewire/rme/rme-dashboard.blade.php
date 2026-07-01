<div class="max-w-6xl mx-auto space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Rekam Medis Elektronik</h2>

    <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">No. Antrian</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">No. RM</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama Pasien</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Poli</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($this->queues as $queue)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 font-medium text-gray-900">#{{ $queue->queue_number }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $queue->patient->no_rm }}</td>
                        <td class="px-4 py-3 text-gray-900">{{ $queue->patient->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ ucfirst($queue->poli) }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-700">
                                {{ $queue->status === 'waiting' ? 'Menunggu' : 'Dipanggil' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button class="relative inline-flex items-center justify-center rounded-lg bg-primary px-3 py-1.5 text-xs font-medium text-white hover:bg-primary-hover transition-colors min-w-[4rem] h-[30px]"
                                    wire:click="selectQueue({{ $queue->id }})"
                                    wire:loading.attr="disabled"
                                    wire:target="selectQueue">
                                <span wire:loading.class="invisible" wire:target="selectQueue">Lihat</span>
                                <span wire:loading.class.remove="hidden" class="hidden absolute inset-0 flex items-center justify-center"
                                      wire:target="selectQueue">
                                    <svg class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                </span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            Tidak ada antrian pasien
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-start justify-center gap-4 p-4 bg-black/50 overflow-y-auto"
             wire:click.self="closeModal">
            <div class="sticky top-8 w-full max-w-md rounded-xl border border-gray-200 bg-white shadow-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Data Pasien</h3>
                        <button class="inline-flex items-center justify-center h-7 w-7 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors"
                                wire:click="closeModal">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="text-sm space-y-2">
                        <p><span class="font-medium text-gray-500">No. RM:</span> <span class="text-gray-900">{{ $this->selectedQueue->patient->no_rm }}</span></p>
                        <p><span class="font-medium text-gray-500">NIK:</span> <span class="text-gray-900">{{ $this->selectedQueue->patient->nik }}</span></p>
                        <p><span class="font-medium text-gray-500">Nama:</span> <span class="text-gray-900">{{ $this->selectedQueue->patient->name }}</span></p>
                        <p><span class="font-medium text-gray-500">Tgl Lahir:</span> <span class="text-gray-900">{{ $this->selectedQueue->patient->birth_date }}</span></p>
                        <p><span class="font-medium text-gray-500">Gender:</span> <span class="text-gray-900">{{ $this->selectedQueue->patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</span></p>
                        <p><span class="font-medium text-gray-500">Telepon:</span> <span class="text-gray-900">{{ $this->selectedQueue->patient->phone ?? '-' }}</span></p>
                        <p><span class="font-medium text-gray-500">Alamat:</span> <span class="text-gray-900">{{ $this->selectedQueue->patient->address ?? '-' }}</span></p>
                        <p><span class="font-medium text-gray-500">Poli:</span> <span class="text-gray-900">{{ ucfirst($this->selectedQueue->poli) }}</span></p>
                    </div>

                    @if ($this->patientHistory->isNotEmpty())
                        <hr class="border-t border-gray-200 my-4">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Riwayat Kunjungan</h3>
                        <div class="space-y-2 max-h-48 overflow-y-auto">
                            @foreach ($this->patientHistory as $record)
                                <div class="text-xs border-b border-gray-100 pb-2 last:border-0 last:pb-0">
                                    <p class="font-medium text-gray-700">{{ $record->created_at->format('d M Y') }}</p>
                                    <p class="text-gray-500">Diagnosis: {{ $record->diagnosis }}</p>
                                    <p class="text-gray-400">Dokter: {{ $record->doctor->name }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="sticky top-8 w-full max-w-lg rounded-xl border border-gray-200 bg-white shadow-lg">
                <div class="p-5">
                    @if ($step === 'examination')
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Form Pemeriksaan</h3>
                            </div>
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
                            <button class="mt-4 w-full inline-flex items-center justify-center rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-hover transition-colors" wire:click="saveMedicalRecord">
                                Simpan Pemeriksaan
                            </button>
                        </div>
                    @else
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Resep Obat</h3>
                                <button class="inline-flex items-center rounded-lg bg-amber-600 px-4 py-2 text-sm font-medium text-white hover:bg-amber-700 transition-colors"
                                        wire:click="completeWithoutPrescription">
                                    Selesai Tanpa Resep
                                </button>
                            </div>

                            <div class="rounded-xl border border-green-200 bg-green-50 p-3 mb-4">
                                <div class="flex items-center gap-2 text-green-800 text-sm">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="font-medium">Pemeriksaan tersimpan</span>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">Diagnosis: {{ $this->savedMedicalRecord->diagnosis }}</p>
                            </div>

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
                                    @error('medicineQty') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <button class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors" wire:click="addMedicine">
                                    Tambah
                                </button>
                            </div>

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
        </div>
    @endif
</div>
