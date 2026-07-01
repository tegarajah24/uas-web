<div class="max-w-3xl mx-auto p-4 space-y-6">
    <h2 class="text-2xl font-bold">Pendaftaran Pasien</h2>

    @if ($showSuccess)
        <div class="card card-border bg-base-100 border-success/50">
            <div class="card-body items-center text-center">
                <div class="text-6xl mb-2 text-success">&#10003;</div>
                <h3 class="card-title text-success">Pendaftaran Berhasil</h3>
                <p class="text-lg">Nomor Antrian:</p>
                <div class="text-5xl font-bold text-primary">{{ $lastQueueNumber }}</div>
                <p class="text-base-content/70">
                    {{ $selectedPatient->name }} &middot; {{ ucfirst($poli) }}
                </p>
                <div class="card-actions mt-4">
                    <button class="btn btn-primary" wire:click="resetAndStart">Daftar Pasien Baru</button>
                </div>
            </div>
        </div>
    @else
        <div class="card card-border bg-base-100">
            <div class="card-body">
                <h3 class="card-title">Cari Pasien</h3>
                <div class="join w-full">
                    <input type="text" class="input input-bordered join-item w-full"
                           placeholder="Cari No. RM atau NIK..." wire:model.live.debounce.500ms="searchQuery"
                           wire:keydown.enter="searchPatient">
                    <button class="btn btn-primary join-item" wire:click="searchPatient">Cari</button>
                    <button class="btn btn-soft join-item" wire:click="startNewRegistration">Baru</button>
                </div>
            </div>
        </div>

        @if ($selectedPatient && !$showForm)
            <div class="card card-border bg-base-100 border-primary/30">
                <div class="card-body">
                    <h3 class="card-title">Pasien Ditemukan</h3>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <span class="font-semibold">No. RM:</span><span>{{ $selectedPatient->no_rm }}</span>
                        <span class="font-semibold">Nama:</span><span>{{ $selectedPatient->name }}</span>
                        <span class="font-semibold">NIK:</span><span>{{ $selectedPatient->nik }}</span>
                        <span class="font-semibold">Tgl Lahir:</span><span>{{ $selectedPatient->birth_date }}</span>
                    </div>
                    <div class="divider">Daftarkan ke Poli</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <select class="select select-bordered" wire:model="poli">
                            <option value="">Pilih Poli</option>
                            <option value="umum">Poli Umum</option>
                            <option value="gigi">Poli Gigi</option>
                            <option value="anak">Poli Anak</option>
                            <option value="kandungan">Poli Kandungan</option>
                        </select>
                        <select class="select select-bordered" wire:model="doctorId">
                            <option value="">Pilih Dokter</option>
                            @foreach ($this->doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card-actions mt-4">
                        <button class="btn btn-primary w-full" wire:click="registerExistingPatient">Daftarkan & Ambil Antrian</button>
                    </div>
                </div>
            </div>
        @endif

        @if ($showForm)
            <div class="card card-border bg-base-100">
                <div class="card-body">
                    <h3 class="card-title">Registrasi Pasien Baru</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="form-control">
                            <span class="label-text">NIK</span>
                            <input type="text" class="input input-bordered" wire:model="nik" required>
                            @error('nik') <span class="text-error text-xs">{{ $message }}</span> @enderror
                        </label>
                        <label class="form-control">
                            <span class="label-text">Nama</span>
                            <input type="text" class="input input-bordered" wire:model="name" required>
                            @error('name') <span class="text-error text-xs">{{ $message }}</span> @enderror
                        </label>
                        <label class="form-control">
                            <span class="label-text">Tanggal Lahir</span>
                            <input type="date" class="input input-bordered" wire:model="birthDate" required>
                            @error('birthDate') <span class="text-error text-xs">{{ $message }}</span> @enderror
                        </label>
                        <label class="form-control">
                            <span class="label-text">Jenis Kelamin</span>
                            <select class="select select-bordered" wire:model="gender">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </label>
                        <label class="form-control">
                            <span class="label-text">No. Telepon</span>
                            <input type="text" class="input input-bordered" wire:model="phone">
                        </label>
                        <label class="form-control">
                            <span class="label-text">Alamat</span>
                            <textarea class="textarea textarea-bordered" wire:model="address"></textarea>
                        </label>
                    </div>

                    <div class="divider">Pilih Poli & Dokter</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <select class="select select-bordered" wire:model="poli">
                            <option value="">Pilih Poli</option>
                            <option value="umum">Poli Umum</option>
                            <option value="gigi">Poli Gigi</option>
                            <option value="anak">Poli Anak</option>
                            <option value="kandungan">Poli Kandungan</option>
                        </select>
                        <select class="select select-bordered" wire:model="doctorId">
                            <option value="">Pilih Dokter</option>
                            @foreach ($this->doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('poli') <span class="text-error text-xs">{{ $message }}</span> @enderror
                    @error('doctorId') <span class="text-error text-xs">{{ $message }}</span> @enderror

                    <div class="card-actions mt-4">
                        <button class="btn btn-primary w-full" wire:click="registerPatient">Daftarkan & Ambil Antrian</button>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
