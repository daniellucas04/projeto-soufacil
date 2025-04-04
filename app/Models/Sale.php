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
    ];

    /**
     * Usa o instânciamento do Model para gerar as parcelas na tabela de recebimento
     */
    protected static function boot() {
        parent::boot();

        static::created(function ($sale) {
            $sale->generateReceipts();
        });
    } 

    public function generateReceipts() {
        $installmentPrice = ($this->price / $this->installment);
        $firstPaymentDate = new \DateTime($this->due_date);
        $installmentPaymentDate = $firstPaymentDate->format('Y-m-d');
        
        for($i = 1; $i <= $this->installment; $i++) {
            if ($i > 1)
                $installmentPaymentDate = $firstPaymentDate->modify("+1 month");
            
            DB::table('receipts')->insert([
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
        return $this->hasMany(Receipt::class);
    }
}
