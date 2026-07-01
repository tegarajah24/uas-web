<div class="max-w-6xl mx-auto space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Kelola Pengguna</h2>

    @error('deleteSelf')
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-600">
            {{ $message }}
        </div>
    @enderror

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Section -->
        <div class="lg:col-span-1">
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-xs">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    {{ $editId ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}
                </h3>

                <form wire:submit.prevent="save" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none" 
                               wire:model="name" placeholder="Nama lengkap...">
                        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none" 
                               wire:model="email" placeholder="email@domain.com">
                        @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Password {{ $editId ? '(Opsional)' : '' }}
                        </label>
                        <input type="password" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none" 
                               wire:model="password" placeholder="{{ $editId ? 'Kosongkan jika tidak diubah...' : 'Minimal 8 karakter...' }}">
                        @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hak Akses / Peran</label>
                        <select class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" 
                                wire:model="role">
                            <option value="">Pilih Peran</option>
                            @foreach ($this->roles as $r)
                                <option value="{{ $r->name }}">{{ ucfirst(str_replace('_', ' ', $r->name)) }}</option>
                            @endforeach
                        </select>
                        @error('role') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-white hover:bg-primary-hover transition-colors">
                            {{ $editId ? 'Simpan Perubahan' : 'Tambah User' }}
                        </button>
                        @if ($editId)
                            <button type="button" wire:click="resetForm" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                Batal
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="lg:col-span-2">
            <div class="rounded-xl border border-gray-200 bg-white shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-900">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="p-4 font-semibold text-gray-600">Pengguna</th>
                                <th class="p-4 font-semibold text-gray-600">Hak Akses</th>
                                <th class="p-4 font-semibold text-gray-600">Terdaftar</th>
                                <th class="p-4 font-semibold text-gray-600 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($this->users as $u)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-4">
                                        <div class="font-bold text-gray-900">{{ $u->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $u->email }}</div>
                                    </td>
                                    <td class="p-4">
                                        @php
                                            $roleName = $u->roles->first()?->name;
                                            $colorClass = match($roleName) {
                                                'super_admin' => 'bg-purple-100 text-purple-800 border-purple-200',
                                                'admin_resepsionis' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'dokter' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                                'farmasi' => 'bg-teal-100 text-teal-800 border-teal-200',
                                                'kasir' => 'bg-amber-100 text-amber-800 border-amber-200',
                                                default => 'bg-gray-100 text-gray-800 border-gray-200'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-medium {{ $colorClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $roleName ?? 'User')) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-xs text-gray-500">
                                        {{ $u->created_at->format('d M Y') }}
                                    </td>
                                    <td class="p-4 text-right space-x-2 shrink-0">
                                        <button wire:click="edit({{ $u->id }})" class="text-primary hover:text-primary-hover font-medium text-xs">
                                            Edit
                                        </button>
                                        @if ($u->id !== auth()->id())
                                            <button wire:click="delete({{ $u->id }})" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"
                                                    class="text-danger hover:text-danger-light font-medium text-xs">
                                                Hapus
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-gray-400">
                                        Tidak ada data pengguna
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
