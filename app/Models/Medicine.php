<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = ['name', 'unit', 'price', 'stock'];

    public function prescriptionItems()
    {
        return $this->hasMany(PrescriptionItem::class);
    }
}
