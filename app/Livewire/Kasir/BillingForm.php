<?php

namespace App\Livewire\Kasir;

use App\Models\Invoice;
use App\Models\MedicalRecord;
use Livewire\Component;

class BillingForm extends Component
{
    public ?int $selectedRecordId = null;

    public string $paymentMethod = '';

    public function selectRecord(int $id)
    {
        $this->selectedRecordId = $id;
        $this->paymentMethod = '';
    }

    public function bayar()
    {
        $this->validate([
            'paymentMethod' => 'required|in:tunai,kartu_kredit,qris',
        ]);

        $record = MedicalRecord::with('prescriptions.items')->findOrFail($this->selectedRecordId);

        $actionCost = $record->action_cost;
        $medicineTotal = 0;

        foreach ($record->prescriptions as $prescription) {
            foreach ($prescription->items as $item) {
                $medicineTotal += $item->qty * $item->price;
            }
        }

        $total = $actionCost + $medicineTotal;

        $invoice = Invoice::create([
            'patient_id' => $record->patient_id,
            'medical_record_id' => $record->id,
            'total' => $total,
            'status' => 'paid',
            'payment_method' => $this->paymentMethod,
            'paid_at' => now(),
        ]);

        $invoice->items()->create([
            'description' => 'Biaya tindakan/konsultasi',
            'amount' => $actionCost,
        ]);

        foreach ($record->prescriptions as $prescription) {
            foreach ($prescription->items as $item) {
                $invoice->items()->create([
                    'description' => $item->medicine->name,
                    'amount' => $item->qty * $item->price,
                ]);
            }
        }

        $this->selectedRecordId = null;
        $this->dispatch('invoice-created');
    }

    public function getQueuedRecordsProperty()
    {
        return MedicalRecord::with(['patient', 'prescriptions.items.medicine'])
            ->whereDoesntHave('invoices')
            ->where(function ($query) {
                $query->whereHas('prescriptions', function ($q) {
                    $q->where('status', 'diserahkan');
                })
                    ->orWhereDoesntHave('prescriptions');
            })
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.kasir.billing-form')
            ->layout('layouts.app');
    }
}
