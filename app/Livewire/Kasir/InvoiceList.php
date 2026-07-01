<?php

namespace App\Livewire\Kasir;

use App\Models\Invoice;
use Livewire\Component;

class InvoiceList extends Component
{
    public string $filterDate = '';

    public function getInvoicesProperty()
    {
        return Invoice::with('patient', 'items')
            ->when($this->filterDate, fn ($q) => $q->whereDate('created_at', $this->filterDate))
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.kasir.invoice-list')
            ->layout('layouts.app');
    }
}
