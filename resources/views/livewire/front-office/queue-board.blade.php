<div class="max-w-6xl mx-auto space-y-6" wire:poll.5s>
    <h2 class="text-2xl font-bold text-gray-900">Papan Antrian</h2>

    <div class="flex flex-wrap gap-3">
        <select class="rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model.live="filterPoli">
            <option value="">Semua Poli</option>
            <option value="umum">Poli Umum</option>
            <option value="gigi">Poli Gigi</option>
            <option value="anak">Poli Anak</option>
            <option value="kandungan">Poli Kandungan</option>
        </select>
        <select class="rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" wire:model.live="filterStatus">
            <option value="">Semua Status</option>
            <option value="waiting">Waiting</option>
            <option value="called">Called</option>
            <option value="done">Done</option>
        </select>
        <span class="text-xs text-gray-400 self-center">Auto-refresh tiap 5 detik</span>
    </div>

    <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                    <th class="px-4 py-3 font-medium text-gray-500">#</th>
                    <th class="px-4 py-3 font-medium text-gray-500">No. RM</th>
                    <th class="px-4 py-3 font-medium text-gray-500">Nama</th>
                    <th class="px-4 py-3 font-medium text-gray-500">Poli</th>
                    <th class="px-4 py-3 font-medium text-gray-500">Dokter</th>
                    <th class="px-4 py-3 font-medium text-gray-500">Status</th>
                    <th class="px-4 py-3 font-medium text-gray-500">Waktu</th>
                    <th class="px-4 py-3 font-medium text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->queues as $queue)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-4 py-3 font-bold text-lg text-gray-900">{{ $queue->queue_number }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $queue->patient->no_rm }}</td>
                        <td class="px-4 py-3 text-gray-900">{{ $queue->patient->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ ucfirst($queue->poli) }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $queue->doctor->name ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if ($queue->status === 'waiting')
                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">Waiting</span>
                            @elseif ($queue->status === 'called')
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">Called</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Done</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $queue->created_at->format('H:i') }}</td>
                        <td class="px-4 py-3">
                            @if ($queue->status === 'waiting')
                                <button class="rounded bg-primary px-2.5 py-1 text-xs font-medium text-white hover:bg-primary-hover transition-colors" wire:click="callPatient({{ $queue->id }})">Panggil</button>
                            @elseif ($queue->status === 'called')
                                <button class="rounded bg-green-600 px-2.5 py-1 text-xs font-medium text-white hover:bg-green-700 transition-colors" wire:click="markDone({{ $queue->id }})">Selesai</button>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-400">Tidak ada antrian</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
