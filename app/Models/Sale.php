<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Sale extends Model
{
    /** @use HasFactory<\Database\Factories\SaleFactory> */
    use HasFactory, Notifiable;

    public static int $maxInstallmentQuantity = 12;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'customer_id',
        'price',
        'installment',
        'due_date',
    ];

    public function customers() {
        return $this->belongsTo(Customer::class);
    }

    public function receipts() {
        return $this->hasMany(Reciept::class);
    }
}
