<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

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
        'status',
    ];

    protected static function boot() {
        parent::boot();

        static::created(function ($sale) {
            $sale->generateReciepts();
        });
    } 

    public function generateReciepts() {
        $installmentPrice = ($this->price / $this->installment);
        $dueDate = new \DateTime($this->due_date);
        $installmentPaymentDate = $dueDate->format('Y-m-d'); // Data de pagamento da primeira parcela
        
        for($i = 1; $i <= $this->installment; $i++) {
            if ($i > 1)
                $installmentPaymentDate = $dueDate->modify("+1 month");
            
            DB::table('reciepts')->insert([
                'sale_id' => $this->id,
                'price' => $installmentPrice,
                'payment_date' => $installmentPaymentDate,
                'created_at' => (new \DateTime ()),
                'updated_at' => (new \DateTime ()),
            ]);
        }
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function receipts() {
        return $this->hasMany(Reciept::class);
    }
}
