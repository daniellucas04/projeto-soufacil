<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Reciept extends Model
{
    /** @use HasFactory<\Database\Factories\RecieptFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'sale_id',
        'price',
        'payment_date',
        'status',
    ];

    public function sale() {
        return $this->belongsTo(Sale::class);
    }
}
