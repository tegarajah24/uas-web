<div class="max-w-5xl mx-auto p-4 space-y-6" wire:poll.5s>
    <h2 class="text-2xl font-bold">Papan Antrian</h2>

    <div class="flex flex-wrap gap-4">
        <select class="select select-bordered select-sm" wire:model.live="filterPoli">
            <option value="">Semua Poli</option>
            <option value="umum">Poli Umum</option>
            <option value="gigi">Poli Gigi</option>
            <option value="anak">Poli Anak</option>
            <option value="kandungan">Poli Kandungan</option>
        </select>
        <select class="select select-bordered select-sm" wire:model.live="filterStatus">
            <option value="">Semua Status</option>
            <option value="waiting">Waiting</option>
            <option value="called">Called</option>
            <option value="done">Done</option>
        </select>
        <span class="text-sm self-center text-base-content/60">Auto-refresh tiap 5 detik</span>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No. RM</th>
                    <th>Nama</th>
                    <th>Poli</th>
                    <th>Dokter</th>
                    <th>Status</th>
                    <th>Waktu Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->queues as $queue)
                    <tr>
                        <td class="text-lg font-bold">{{ $queue->queue_number }}</td>
                        <td>{{ $queue->patient->no_rm }}</td>
                        <td>{{ $queue->patient->name }}</td>
                        <td>{{ ucfirst($queue->poli) }}</td>
                        <td>{{ $queue->doctor->name ?? '-' }}</td>
                        <td>
                            @switch($queue->status)
                                @case('waiting')
                                    <span class="badge badge-warning">Waiting</span>
                                    @break
                                @case('called')
                                    <span class="badge badge-info">Called</span>
                                    @break
                                @case('done')
                                    <span class="badge badge-success">Done</span>
                                    @break
                            @endswitch
                        </td>
                        <td>{{ $queue->created_at->format('H:i') }}</td>
                        <td class="flex gap-1">
                            @if ($queue->status === 'waiting')
                                <button class="btn btn-xs btn-primary" wire:click="callPatient({{ $queue->id }})">Panggil</button>
                            @elseif ($queue->status === 'called')
                                <button class="btn btn-xs btn-success" wire:click="markDone({{ $queue->id }})">Selesai</button>
                            @else
                                <span class="text-xs text-base-content/50">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-base-content/50 py-8">Tidak ada antrian</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
