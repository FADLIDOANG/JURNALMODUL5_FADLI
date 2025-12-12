<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $fillable = [
        'kode_matakuliah',
        'nama_matakuliah',
        'sks',
        'semester',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->kode_matakuliah)) {
                // Get the count of existing records + 1
                $count = MataKuliah::count() + 1;
                $model->kode_matakuliah = 'MK' . str_pad($count, 3, '0', STR_PAD_LEFT);
            }
        });
    }
}
