<?php

namespace App\Livewire\Farmasi;

use App\Models\Medicine;
use Livewire\Component;

class MedicineStock extends Component
{
    public string $name = '';
    public string $unit = 'tablet';
    public string $price = '';
    public string $stock = '';
    public ?int $editId = null;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Medicine::updateOrCreate(
            ['id' => $this->editId],
            ['name' => $this->name, 'unit' => $this->unit, 'price' => $this->price, 'stock' => $this->stock],
        );

        $this->resetForm();
    }

    public function edit(int $id)
    {
        $medicine = Medicine::findOrFail($id);
        $this->editId = $medicine->id;
        $this->name = $medicine->name;
        $this->unit = $medicine->unit;
        $this->price = (string) $medicine->price;
        $this->stock = (string) $medicine->stock;
    }

    public function delete(int $id)
    {
        Medicine::findOrFail($id)->delete();
    }

    public function resetForm()
    {
        $this->editId = null;
        $this->name = '';
        $this->unit = 'tablet';
        $this->price = '';
        $this->stock = '';
    }

    public function render()
    {
        return view('livewire.farmasi.medicine-stock', [
            'medicines' => Medicine::latest()->get(),
        ])->layout('layouts.app');
    }
}
