<?php

namespace App\Livewire\FrontOffice;

use App\Models\Queue;
use Livewire\Component;

class QueueBoard extends Component
{
    public string $filterPoli = '';

    public string $filterStatus = '';

    protected $queryString = ['filterPoli', 'filterStatus'];

    public function callPatient(int $queueId)
    {
        Queue::where('id', $queueId)
            ->where('status', 'waiting')
            ->update(['status' => 'called']);

        $this->dispatch('queue-updated');
    }

    public function markDone(int $queueId)
    {
        Queue::where('id', $queueId)
            ->where('status', 'called')
            ->update(['status' => 'done']);

        $this->dispatch('queue-updated');
    }

    public function getQueuesProperty()
    {
        return Queue::with('patient')
            ->when($this->filterPoli, fn ($q) => $q->where('poli', $this->filterPoli))
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->latest('created_at')
            ->get();
    }

    public function render()
    {
        return view('livewire.front-office.queue-board')
            ->layout('layouts.app');
    }
}
