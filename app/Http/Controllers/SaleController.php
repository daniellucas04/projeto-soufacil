<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request): View {
        $filter = Customer::query();

        if ($request->has('filter')) {
            $filter->where('name', 'LIKE', "%{$request->query('filter')}%")
                ->orWhere('phone', 'LIKE', "%{$request->query('filter')}%")
                ->orWhere('email', 'LIKE', "%{$request->query('filter')}%")
                ->orWhere('cpf_cnpj', 'LIKE', "%{$request->query('filter')}%");
        }

        return view('auth.sales.list', ['customers' => $filter->simplePaginate(10)]);
    }

    public function customers(Request $request): View {        
        $filter = Sale::query();
        $filter->join('customers', 'customers.id', '=', 'sales.customer_id');

        if ($request->has('filter') AND !empty($request->query('filter'))) {
            $date = null;
            if (str_contains($request->query('filter'), '/')) {
                $date = \DateTime::createFromFormat('d/m/Y', $request->query('filter'))->format('Y-m-d');
            }

            $filter->where('price', '=', $this->preparePrice($request->query('filter')))
            ->orWhere('due_date', '=', $date ?? $request->query('filter'))
            ->orWhere('status', '=', $request->query('filter'));
        }

        return view('auth.sales.customers', ['sales' => $filter->orderBy('sales.created_at', 'desc')->simplePaginate(10)]);
    }

    public function create(Request $request, string $uuid) {
        return view('auth.sales.create', ['customer' => Customer::whereUuid($uuid)->firstOrFail(), 'maxInstallmentQuantity' => Sale::$maxInstallmentQuantity]);
    }
    
    public function edit(Request $request, string $uuid) {
        return view('auth.sales.edit', ['customer' => Customer::whereUuid($uuid)->firstOrFail(), 'maxInstallmentQuantity' => Sale::$maxInstallmentQuantity]);
    }

    public function store(Request $request, string $uuid) {
        $data = $request->all();
        $data['price'] = $this->preparePrice($data['price']);

        $validated = validator($data, [
            'price' => 'required|numeric|min:0.01',
            'due_date' => 'required|date|after_or_equal:today',
            'installment' => 'required|integer|min:1',
        ]);

        try {
            $customer = Customer::whereUuid($uuid)->firstOrFail();
            $customer->sales()->create($data);
            
            // Lógica para possível adição de parcelamento da venda
            // $installmentPrice = ($validated['price'] / $validated['installment']);
            // $dueDate = new DateTime($validated['due_date']);
            // $installmentPaymentDate = $dueDate->format('Y-m-d'); // Data de pagamento da primeira parcela
            // for($i = 1; $i <= $validated['installment']; $i++) {
            //     if ($i > 1)
            //         $installmentPaymentDate = $dueDate->modify("+1 month");
                
            //     DB::table('invoices')->insert([
            //         'sale_id' => $createdSale->id,
            //         'price' => $installmentPrice,
            //         'payment_date' => $installmentPaymentDate,
            //         'created_at' => (new DateTime ()),
            //         'updated_at' => (new DateTime ()),
            //     ]);
            // }

            session()->flash('success', "Sale created successfully for {$customer->name}!");
            return redirect('/sales/customers');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    function preparePrice(string $price) {
        return floatval(str_replace(['R$ ', '.', ',',], ['', '', '.'], $price));
    }

    private function rules(?string $uuid = null) {
        $rules = [
            'name' => 'required|string|max:255',
            'cpf_cnpj' => 'required|string|max:255',
            'phone' => 'required|phone:BR',
            'email' => ['required', 'email', 'unique:sales'],
        ];
    
        if (!empty($uuid)) {
            $rules['email'] = array_slice($rules['email'], 0, 2);
        }

        return $rules;
    }
}
