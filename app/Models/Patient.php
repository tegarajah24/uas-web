<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['no_rm', 'nik', 'name', 'birth_date', 'gender', 'phone', 'address'];

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
