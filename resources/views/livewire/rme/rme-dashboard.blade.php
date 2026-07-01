<div class="max-w-6xl mx-auto p-4 space-y-6">
    <h2 class="text-2xl font-bold">Rekam Medis Elektronik</h2>

    <div class="flex flex-wrap gap-3">
        @forelse ($this->queues as $queue)
            <button class="btn {{ $selectedQueueId === $queue->id ? 'btn-primary' : 'btn-outline' }}"
                    wire:click="selectQueue({{ $queue->id }})">
                #{{ $queue->queue_number }}
                <span class="text-xs opacity-70">{{ $queue->patient->name }}</span>
            </button>
        @empty
            <p class="text-base-content/50">Tidak ada antrian pasien</p>
        @endforelse
    </div>

    @if ($this->selectedQueue)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1 space-y-4">
                <div class="card card-border bg-base-100">
                    <div class="card-body">
                        <h3 class="card-title text-sm">Pasien</h3>
                        <div class="text-sm space-y-1">
                            <p><span class="font-semibold">RM:</span> {{ $this->selectedQueue->patient->no_rm }}</p>
                            <p><span class="font-semibold">Nama:</span> {{ $this->selectedQueue->patient->name }}</p>
                            <p><span class="font-semibold">NIK:</span> {{ $this->selectedQueue->patient->nik }}</p>
                            <p><span class="font-semibold">Poli:</span> {{ ucfirst($this->selectedQueue->poli) }}</p>
                        </div>
                    </div>
                </div>

                @if ($this->patientHistory->isNotEmpty())
                    <div class="card card-border bg-base-100">
                        <div class="card-body">
                            <h3 class="card-title text-sm">Riwayat Kunjungan</h3>
                            <div class="space-y-2">
                                @foreach ($this->patientHistory as $record)
                                    <div class="text-xs border-b pb-2 last:border-0">
                                        <p class="font-semibold">{{ $record->created_at->format('d M Y') }}
                                            @if ($record->id === $savedMedicalRecordId)
                                                <span class="badge badge-success badge-xs">baru</span>
                                            @endif
                                        </p>
                                        <p>Diagnosis: {{ $record->diagnosis }}</p>
                                        <p>Dokter: {{ $record->doctor->name }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-2 space-y-4">
                @if (!$savedMedicalRecordId)
                    <div class="card card-border bg-base-100">
                        <div class="card-body">
                            <h3 class="card-title">Form Pemeriksaan</h3>
                            <div class="grid grid-cols-1 gap-4">
                                <label class="form-control">
                                    <span class="label-text">Keluhan</span>
                                    <textarea class="textarea textarea-bordered" wire:model="complaint" rows="2"></textarea>
                                    @error('complaint') <span class="text-error text-xs">{{ $message }}</span> @enderror
                                </label>
                                <label class="form-control">
                                    <span class="label-text">Diagnosis</span>
                                    <textarea class="textarea textarea-bordered" wire:model="diagnosis" rows="2"></textarea>
                                    @error('diagnosis') <span class="text-error text-xs">{{ $message }}</span> @enderror
                                </label>
                                <label class="form-control">
                                    <span class="label-text">Biaya Tindakan (Rp)</span>
                                    <input type="number" class="input input-bordered" wire:model="actionCost" min="0">
                                    @error('actionCost') <span class="text-error text-xs">{{ $message }}</span> @enderror
                                </label>
                            </div>
                            <div class="card-actions mt-4">
                                <button class="btn btn-primary" wire:click="saveMedicalRecord">Simpan Pemeriksaan</button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card card-border bg-base-100 border-success/30">
                        <div class="card-body">
                            <div class="flex items-center gap-2 text-success">
                                <span>&#10003;</span>
                                <span class="font-semibold">Pemeriksaan tersimpan</span>
                            </div>
                            <p class="text-sm">{{ $this->savedMedicalRecord->diagnosis }}</p>
                        </div>
                    </div>

                    <div class="card card-border bg-base-100">
                        <div class="card-body">
                            <h3 class="card-title">Resep Obat</h3>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
                                <label class="form-control">
                                    <span class="label-text">Obat</span>
                                    <select class="select select-bordered" wire:model="selectedMedicineId">
                                        <option value="">Pilih obat</option>
                                        @foreach ($this->medicines as $medicine)
                                            <option value="{{ $medicine->id }}">
                                                {{ $medicine->name }} (stok: {{ $medicine->stock }})
                                            </option>
                                        @endforeach
                                    </select>
                                </label>
                                <label class="form-control">
                                    <span class="label-text">Jumlah</span>
                                    <input type="number" class="input input-bordered" wire:model="medicineQty" min="1">
                                </label>
                                <button class="btn btn-soft" wire:click="addMedicine">Tambah</button>
                            </div>
                            @error('medicineQty') <span class="text-error text-xs">{{ $message }}</span> @enderror

                            @if (!empty($prescriptionItems))
                                <div class="overflow-x-auto mt-4">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Obat</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Subtotal</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($prescriptionItems as $i => $item)
                                                <tr>
                                                    <td>{{ $item['name'] }}</td>
                                                    <td>{{ $item['qty'] }}</td>
                                                    <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($item['qty'] * $item['price'], 0, ',', '.') }}</td>
                                                    <td>
                                                        <button class="btn btn-xs btn-ghost text-error"
                                                                wire:click="removeMedicine({{ $i }})">hapus</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card-actions mt-4">
                                    <button class="btn btn-primary" wire:click="savePrescription">
                                        Simpan Resep & Selesaikan
                                    </button>
                                </div>
                            @endif
                            @error('prescriptionItems') <span class="text-error text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
