<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'category_id',
        'type',
        'amount',
        'description',
        'transaction_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    // Relación: Una transacción pertenece a una cuenta
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    // Relación: Una transacción pertenece a una categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
