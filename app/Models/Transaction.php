<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'transaction_type_id',
        'description',
        'item_unit',
        'item_count',
        'item_price',
        'total',
        'transaction_date',
    ];

    public function transactionType(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id', 'id');
    }

    protected function itemCount(): Attribute
    {
        return Attribute::make(get: fn($value) => $value / 100);
    }

    protected function itemPrice(): Attribute
    {
        return Attribute::make(get: fn($value) => $value / 100);
    }

    protected function total(): Attribute
    {
        return Attribute::make(get: fn($value) => $value / 100);
    }
}
