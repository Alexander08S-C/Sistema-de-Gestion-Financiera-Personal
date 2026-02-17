<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'icon',
        'color',
    ];

    // Relación: Una categoría tiene muchas transacciones
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Relación: Una categoría tiene muchos presupuestos
    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }
}
