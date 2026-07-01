<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold">Stok Obat</h2>
        <button class="btn btn-primary" wire:click="resetForm">Tambah Obat</button>
    </div>

    @if (!$editId && !$name && !session()->has('errors'))
    @else
        <div class="card card-border bg-base-100">
            <div class="card-body">
                <h3 class="card-title">{{ $editId ? 'Edit Obat' : 'Tambah Obat' }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <input type="text" class="input input-bordered" placeholder="Nama obat" wire:model="name">
                    <select class="select select-bordered" wire:model="unit">
                        <option value="tablet">Tablet</option>
                        <option value="botol">Botol</option>
                        <option value="strip">Strip</option>
                        <option value="kaplet">Kaplet</option>
                        <option value="sirup">Sirup</option>
                    </select>
                    <input type="number" class="input input-bordered" placeholder="Harga" wire:model="price" min="0">
                    <input type="number" class="input input-bordered" placeholder="Stok" wire:model="stock" min="0">
                </div>
                @error('name') <span class="text-error text-xs">{{ $message }}</span> @enderror
                <div class="card-actions mt-3">
                    <button class="btn btn-primary" wire:click="save">Simpan</button>
                    <button class="btn btn-ghost" wire:click="resetForm">Batal</button>
                </div>
            </div>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($medicines as $medicine)
                    <tr>
                        <td>{{ $medicine->name }}</td>
                        <td>{{ $medicine->unit }}</td>
                        <td>Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $medicine->stock > 10 ? 'badge-success' : ($medicine->stock > 0 ? 'badge-warning' : 'badge-error') }}">
                                {{ $medicine->stock }}
                            </span>
                        </td>
                        <td class="flex gap-1">
                            <button class="btn btn-xs btn-soft" wire:click="edit({{ $medicine->id }})">Edit</button>
                            <button class="btn btn-xs btn-soft text-error" wire:click="delete({{ $medicine->id }})"
                                    wire:confirm="Hapus {{ $medicine->name }}?">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-base-content/50 py-8">Belum ada obat</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
