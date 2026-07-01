<div class="max-w-6xl mx-auto space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Pendaftaran Pasien</h2>

    @if ($showSuccess)
        <div class="rounded-xl border border-green-200 bg-green-50 p-8 text-center">
            <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-green-100 text-green-600 mb-4">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-green-800 mb-2">Pendaftaran Berhasil</h3>
            <p class="text-sm text-gray-500 mb-4">Nomor Antrian Anda</p>
            <p class="text-5xl font-bold text-primary mb-2">{{ $lastQueueNumber }}</p>
            <p class="text-sm text-gray-500">{{ $selectedPatient->name }} &middot; {{ ucfirst($poli) }}</p>
            <button class="mt-6 inline-flex items-center rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-hover transition-colors" wire:click="resetAndStart">
                Daftar Pasien Baru
            </button>
        </div>
    @else
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="flex gap-2">
                <input type="text" class="block flex-1 rounded-lg border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none"
                       placeholder="Cari No. RM, NIK, atau Nama..." wire:model.live.debounce.300ms="searchQuery">
                <button class="inline-flex items-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover transition-colors" wire:click="startNewRegistration">
                    + Pasien Baru
                </button>
            </div>
        </div>

        <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">No. RM</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">NIK</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Tgl Lahir</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Gender</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($this->patients as $patient)
                        <tr class="hover:bg-gray-50 transition-colors {{ $selectedPatient && $selectedPatient->id === $patient->id ? 'bg-primary-50' : '' }}">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $patient->no_rm }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $patient->nik }}</td>
                            <td class="px-4 py-3 text-gray-900">{{ $patient->name }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $patient->birth_date }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td class="px-4 py-3 text-center">
                                <button class="inline-flex items-center rounded-lg bg-primary px-3 py-1.5 text-xs font-medium text-white hover:bg-primary-hover transition-colors"
                                        wire:click="selectPatient({{ $patient->id }})">
                                    Pilih
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                @if (strlen(trim($searchQuery)) >= 1)
                                    Tidak ada pasien yang cocok dengan pencarian "{{ $searchQuery }}"
                                @else
                                    Belum ada data pasien. Klik <strong>+ Pasien Baru</strong> untuk mendaftarkan pasien pertama.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($this->patients->hasPages())
                <div class="border-t border-gray-200 px-4 py-3">
                    {{ $this->patients->links() }}
                </div>
            @endif
        </div>

        @if ($selectedPatient && !$showForm)
            <div class="rounded-xl border border-blue-200 bg-blue-50 p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">Pasien Dipilih: {{ $selectedPatient->name }}</h3>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <span class="font-medium text-gray-600">No. RM:</span><span class="text-gray-900">{{ $selectedPatient->no_rm }}</span>
                    <span class="font-medium text-gray-600">NIK:</span><span class="text-gray-900">{{ $selectedPatient->nik }}</span>
                    <span class="font-medium text-gray-600">Tgl Lahir:</span><span class="text-gray-900">{{ $selectedPatient->birth_date }}</span>
                    <span class="font-medium text-gray-600">Gender:</span><span class="text-gray-900">{{ $selectedPatient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>
                <hr class="border-t border-blue-200 my-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <select class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model="poli">
                        <option value="">Pilih Poli</option>
                        <option value="umum">Poli Umum</option>
                        <option value="gigi">Poli Gigi</option>
                        <option value="anak">Poli Anak</option>
                        <option value="kandungan">Poli Kandungan</option>
                    </select>
                    <select class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model="doctorId">
                        <option value="">Pilih Dokter</option>
                        @foreach ($this->doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="mt-4 w-full inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-white hover:bg-primary-hover transition-colors" wire:click="registerExistingPatient">
                    Daftarkan & Ambil Antrian
                </button>
            </div>
        @endif

        @if ($showForm)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                 x-data x-show="$wire.showForm" x-cloak
                 @click.self="$wire.resetForm()">
                <div class="w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-xl border border-gray-200 bg-white p-6 shadow-lg mx-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Registrasi Pasien Baru</h3>
                        <button class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors"
                                wire:click="resetForm">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                            <input type="text" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model="nik">
                            @error('nik') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model="name">
                            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                            <input type="date" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model="birthDate">
                            @error('birthDate') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                            <select class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model="gender">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                            <input type="text" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model="phone">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <textarea class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model="address" rows="2"></textarea>
                        </div>
                    </div>

                    <hr class="border-t border-gray-200 my-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <select class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model="poli">
                            <option value="">Pilih Poli</option>
                            <option value="umum">Poli Umum</option>
                            <option value="gigi">Poli Gigi</option>
                            <option value="anak">Poli Anak</option>
                            <option value="kandungan">Poli Kandungan</option>
                        </select>
                        <select class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model="doctorId">
                            <option value="">Pilih Dokter</option>
                            @foreach ($this->doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('poli') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    @error('doctorId') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror

                    <button class="mt-4 w-full inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-white hover:bg-primary-hover transition-colors" wire:click="registerPatient">
                        Daftarkan & Ambil Antrian
                    </button>
                </div>
            </div>
        @endif
    @endif
</div>
