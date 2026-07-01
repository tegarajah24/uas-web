<?php

namespace App\Livewire\Rme;

use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\Queue;
use Livewire\Component;

class RmeDashboard extends Component
{
    public ?int $selectedQueueId = null;

    public ?int $savedMedicalRecordId = null;

    public string $complaint = '';

    public string $diagnosis = '';

    public string $actionCost = '0';

    public string $selectedMedicineId = '';

    public int $medicineQty = 1;

    public array $prescriptionItems = [];

    public bool $showForm = false;

    public function selectQueue(int $queueId)
    {
        $this->selectedQueueId = $queueId;
        $this->savedMedicalRecordId = null;
        $this->showForm = true;
        $this->complaint = '';
        $this->diagnosis = '';
        $this->actionCost = '0';
        $this->prescriptionItems = [];
        $this->selectedMedicineId = '';
    }

    public function saveMedicalRecord()
    {
        $this->validate([
            'complaint' => 'required|string',
            'diagnosis' => 'required|string',
            'actionCost' => 'required|numeric|min:0',
        ]);

        $queue = $this->selectedQueue;

        $record = MedicalRecord::create([
            'patient_id' => $queue->patient_id,
            'doctor_id' => auth()->id(),
            'queue_id' => $queue->id,
            'complaint' => $this->complaint,
            'diagnosis' => $this->diagnosis,
            'action_cost' => $this->actionCost,
        ]);

        $this->savedMedicalRecordId = $record->id;

        $this->dispatch('medical-record-saved');
    }

    public function addMedicine()
    {
        $this->validate([
            'selectedMedicineId' => 'required|exists:medicines,id',
            'medicineQty' => 'required|integer|min:1',
        ]);

        $medicine = Medicine::findOrFail($this->selectedMedicineId);

        if ($medicine->stock < $this->medicineQty) {
            $this->addError('medicineQty', "Stok {$medicine->name} tidak mencukupi (sisa: {$medicine->stock})");

            return;
        }

        $this->prescriptionItems[] = [
            'medicine_id' => $medicine->id,
            'name' => $medicine->name,
            'qty' => $this->medicineQty,
            'price' => $medicine->price,
        ];

        $this->selectedMedicineId = '';
        $this->medicineQty = 1;
    }

    public function removeMedicine(int $index)
    {
        unset($this->prescriptionItems[$index]);
        $this->prescriptionItems = array_values($this->prescriptionItems);
    }

    public function savePrescription()
    {
        if (empty($this->prescriptionItems)) {
            $this->addError('prescriptionItems', 'Tambahkan minimal 1 obat');

            return;
        }

        $prescription = Prescription::create([
            'medical_record_id' => $this->savedMedicalRecordId,
            'status' => 'menunggu',
        ]);

        foreach ($this->prescriptionItems as $item) {
            $prescription->items()->create([
                'medicine_id' => $item['medicine_id'],
                'qty' => $item['qty'],
                'price' => $item['price'],
            ]);
        }

        Queue::where('id', $this->selectedQueueId)->update(['status' => 'done']);

        $this->resetRecordForm();

        $this->dispatch('prescription-saved');
    }

    public function completeWithoutPrescription()
    {
        if (! $this->savedMedicalRecordId) {
            $this->addError('prescriptionItems', 'Simpan pemeriksaan terlebih dahulu sebelum menyelesaikan');

            return;
        }

        Queue::where('id', $this->selectedQueueId)->update(['status' => 'done']);

        $this->resetRecordForm();

        $this->dispatch('prescription-saved');
    }

    private function resetRecordForm()
    {
        $this->selectedQueueId = null;
        $this->savedMedicalRecordId = null;
        $this->showForm = false;
        $this->complaint = '';
        $this->diagnosis = '';
        $this->actionCost = '0';
        $this->prescriptionItems = [];
        $this->selectedMedicineId = '';
    }

    public function getSelectedQueueProperty()
    {
        return $this->selectedQueueId
            ? Queue::with('patient')->find($this->selectedQueueId)
            : null;
    }

    public function getQueuesProperty()
    {
        return Queue::with('patient')
            ->where('doctor_id', auth()->id())
            ->whereIn('status', ['waiting', 'called'])
            ->latest('created_at')
            ->get();
    }

    public function getPatientHistoryProperty()
    {
        if (! $this->selectedQueue) {
            return collect();
        }

        return MedicalRecord::with('doctor')
            ->where('patient_id', $this->selectedQueue->patient_id)
            ->latest()
            ->get();
    }

    public function getMedicinesProperty()
    {
        return Medicine::where('stock', '>', 0)->get();
    }

    public function getSavedMedicalRecordProperty()
    {
        return $this->savedMedicalRecordId
            ? MedicalRecord::find($this->savedMedicalRecordId)
            : null;
    }

    public function render()
    {
        return view('livewire.rme.rme-dashboard')
            ->layout('layouts.app');
    }
}
