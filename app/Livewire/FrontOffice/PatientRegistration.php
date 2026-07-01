<?php

namespace App\Livewire\FrontOffice;

use App\Models\Patient;
use App\Models\Queue;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class PatientRegistration extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    public string $searchQuery = '';

    public ?Patient $selectedPatient = null;

    public string $nik = '';

    public string $name = '';

    public string $birthDate = '';

    public string $gender = 'L';

    public string $phone = '';

    public string $address = '';

    public string $poli = '';

    public string $doctorId = '';

    public ?int $lastQueueNumber = null;

    public bool $showForm = false;

    public bool $showSuccess = false;

    public function searchPatient()
    {
    }

    public function selectPatient(int $id)
    {
        $patient = Patient::findOrFail($id);
        $this->selectedPatient = $patient;
        $this->showForm = false;
        $this->showSuccess = false;
        $this->poli = '';
        $this->doctorId = '';
    }

    public function getPatientsProperty()
    {
        $query = trim($this->searchQuery);

        return Patient::when(strlen($query) >= 1, function ($q) use ($query) {
            $q->where('no_rm', 'like', "%{$query}%")
              ->orWhere('nik', 'like', "%{$query}%")
              ->orWhere('name', 'like', "%{$query}%");
        })
            ->latest()
            ->paginate(10);
    }

    public function startNewRegistration()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->selectedPatient = null;
        $this->showSuccess = false;
    }

    public function registerPatient()
    {
        $this->validate([
            'nik' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'birthDate' => 'required|date',
            'gender' => 'required|in:L,P',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'poli' => 'required|string',
            'doctorId' => 'required|exists:users,id',
        ]);

        $no_rm = $this->generateNoRm();

        $patient = Patient::create([
            'no_rm' => $no_rm,
            'nik' => $this->nik,
            'name' => $this->name,
            'birth_date' => $this->birthDate,
            'gender' => $this->gender,
            'phone' => $this->phone ?: null,
            'address' => $this->address ?: null,
        ]);

        $queueNumber = $this->generateQueueNumber($this->poli);

        Queue::create([
            'patient_id' => $patient->id,
            'poli' => $this->poli,
            'doctor_id' => $this->doctorId,
            'queue_number' => $queueNumber,
            'status' => 'waiting',
        ]);

        $this->lastQueueNumber = $queueNumber;
        $this->selectedPatient = $patient;
        $this->showForm = false;
        $this->showSuccess = true;
    }

    public function registerExistingPatient()
    {
        $this->validate([
            'poli' => 'required|string',
            'doctorId' => 'required|exists:users,id',
        ]);

        $queueNumber = $this->generateQueueNumber($this->poli);

        Queue::create([
            'patient_id' => $this->selectedPatient->id,
            'poli' => $this->poli,
            'doctor_id' => $this->doctorId,
            'queue_number' => $queueNumber,
            'status' => 'waiting',
        ]);

        $this->lastQueueNumber = $queueNumber;
        $this->showSuccess = true;
    }

    public function resetAndStart()
    {
        $this->resetForm();
        $this->selectedPatient = null;
        $this->showForm = false;
        $this->showSuccess = false;
        $this->searchQuery = '';
        $this->lastQueueNumber = null;
        $this->poli = '';
        $this->doctorId = '';
    }

    private function generateNoRm(): string
    {
        $last = Patient::latest('id')->value('no_rm');
        $num = $last ? (int) substr($last, -4) + 1 : 1;

        return 'RM-'.now()->format('Ymd').'-'.str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    private function generateQueueNumber(string $poli): int
    {
        $today = now()->format('Y-m-d');

        return Queue::where('poli', $poli)
            ->whereDate('created_at', $today)
            ->max('queue_number') + 1;
    }

    private function fillFromSearchQuery(string $query): void
    {
        if (ctype_digit($query) && strlen($query) >= 10) {
            $this->nik = $query;
        }
    }

    public function resetForm(): void
    {
        $this->nik = '';
        $this->name = '';
        $this->birthDate = '';
        $this->gender = 'L';
        $this->phone = '';
        $this->address = '';
        $this->poli = '';
        $this->doctorId = '';
        $this->showForm = false;
        $this->resetValidation();
    }

    public function getDoctorsProperty()
    {
        return User::role('dokter')->get();
    }

    public function render()
    {
        return view('livewire.front-office.patient-registration')
            ->layout('layouts.app');
    }
}
