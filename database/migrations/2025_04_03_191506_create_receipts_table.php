<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reciepts', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->default(DB::raw('(UUID())'));
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->date('payment_date');
            $table->enum('status', ['Paid', 'Pending'])->default('Pending');
            $table->timestamps();
        });

        DB::statement("CREATE VIEW get_all_reciepts AS
            	SELECT 
                    reciepts.uuid AS reciept_code, 
                    sales.id AS sale_id, 
                    customers.name AS customer_name, 
                    customers.cpf_cnpj AS customer_document, 
                    sales.uuid AS sale_code, 
                    reciepts.price AS reciept_price, 
                    reciepts.payment_date AS payment_date, 
                    sales.created_at AS sale_date, 
                    reciepts.status as reciept_status 
                FROM reciepts
                INNER JOIN sales ON sales.id = reciepts.sale_id 
                INNER JOIN customers ON customers.id = sales.customer_id;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
        DB::statement("DROP VIEW IF EXISTS get_all_reciepts");
    }
};
