<?php

namespace App\Livewire\Farmasi;

use App\Models\Medicine;
use App\Models\Prescription;
use Livewire\Component;

class PrescriptionQueue extends Component
{
    public string $filterStatus = 'menunggu';

    public function proses(string $status, int $id)
    {
        $prescription = Prescription::with('items.medicine')->findOrFail($id);

        if ($status === 'diserahkan') {
            foreach ($prescription->items as $item) {
                $medicine = Medicine::find($item->medicine_id);
                if ($medicine && $medicine->stock < $item->qty) {
                    $this->addError("stock_{$id}", "Stok {$medicine->name} tidak mencukupi");

                    return;
                }
                $medicine?->decrement('stock', $item->qty);
            }
        }

        $prescription->update(['status' => $status]);
    }

    public function getPrescriptionsProperty()
    {
        return Prescription::with(['medicalRecord.patient', 'medicalRecord.doctor', 'items.medicine'])
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.farmasi.prescription-queue')
            ->layout('layouts.app');
    }
}
