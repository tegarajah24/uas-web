<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Stok Obat</h2>
        <button class="inline-flex items-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover transition-colors" wire:click="resetForm">
            Tambah Obat
        </button>
    </div>

    @if ($editId || (!$editId && ($name || old('name'))))
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $editId ? 'Edit Obat' : 'Tambah Obat' }}</h3>
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <input type="text" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="Nama obat" wire:model="name">
                <select class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model="unit">
                    <option value="tablet">Tablet</option>
                    <option value="botol">Botol</option>
                    <option value="strip">Strip</option>
                    <option value="kaplet">Kaplet</option>
                    <option value="sirup">Sirup</option>
                </select>
                <input type="number" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="Harga" wire:model="price" min="0">
                <input type="number" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="Stok" wire:model="stock" min="0">
            </div>
            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            <div class="flex gap-2 mt-4">
                <button class="inline-flex items-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-hover transition-colors" wire:click="save">Simpan</button>
                <button class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors" wire:click="resetForm">Batal</button>
            </div>
        </div>
    @endif

    <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                    <th class="px-4 py-3 font-medium text-gray-500">Nama</th>
                    <th class="px-4 py-3 font-medium text-gray-500">Satuan</th>
                    <th class="px-4 py-3 font-medium text-gray-500">Harga</th>
                    <th class="px-4 py-3 font-medium text-gray-500">Stok</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($medicines as $medicine)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-900 font-medium">{{ $medicine->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $medicine->unit }}</td>
                        <td class="px-4 py-3 text-gray-700">Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            @if ($medicine->stock > 10)
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">{{ $medicine->stock }}</span>
                            @elseif ($medicine->stock > 0)
                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">{{ $medicine->stock }}</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">{{ $medicine->stock }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-1">
                                <button class="rounded border border-gray-300 bg-white px-2.5 py-1 text-xs font-medium text-gray-700 hover:bg-gray-50 transition-colors" wire:click="edit({{ $medicine->id }})">Edit</button>
                                <button class="rounded border border-red-300 bg-white px-2.5 py-1 text-xs font-medium text-red-600 hover:bg-red-50 transition-colors" wire:click="delete({{ $medicine->id }})"
                                        wire:confirm="Hapus {{ $medicine->name }}?">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada obat</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
