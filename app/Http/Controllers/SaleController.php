<?php

namespace App\Http\Controllers;

use App\Enums\ReturnMessage;
use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request): View {
        $filter = $this->executeSaleFilter($request);  
        
        return view('auth.sales.list', ['sales' => $filter->orderBy('sales.created_at', 'desc')->simplePaginate(10)]);
    }
    
    public function customers(Request $request): View {     
        $filter = $this->executeCustomerFilter($request);

        return view('auth.sales.customers', ['customers' => $filter->simplePaginate(10)]);
    }

    public function create(Request $request, string $uuid) {
        return view('auth.sales.create', ['customer' => Customer::whereUuid($uuid)->firstOrFail(), 'maxInstallmentQuantity' => Sale::$maxInstallmentQuantity]);
    }

    public function store(Request $request, string $uuid) {
        $data = $request->all();
        $data['price'] = $this->preparePrice($data['price']);

        $validated = validator($data, [
            'price' => 'required|numeric|min:0.01',
            'due_date' => 'required|date|after_or_equal:today',
            'installment' => 'required|integer|min:1',
        ])->validate();

        try {
            $customer = Customer::whereUuid($uuid)->firstOrFail();
            $validated['customer_id'] = $customer->id;

            Sale::create($validated);

            session()->flash('success', ReturnMessage::SALE_CREATED_SUCCESS->value);
            return redirect('/sales');
        } catch (\Exception $e) {
            session()->flash('error', ReturnMessage::SALE_CREATED_FAIL->value);
            return redirect()->back();
        }
    }

    private function preparePrice(?string $price = null) {
        return floatval(str_replace(['R$ ', '.', ',',], ['', '', '.'], $price)) ?? null;
    }

    private function executeCustomerFilter(Request $request): Customer|Builder {
        $filter = Customer::query();

        if ($request->has('filter')) {
            $filter->where('name', 'LIKE', "%{$request->query('filter')}%")
                ->orWhere('phone', 'LIKE', "%{$request->query('filter')}%")
                ->orWhere('email', 'LIKE', "%{$request->query('filter')}%")
                ->orWhere('cpf_cnpj', 'LIKE', "%{$request->query('filter')}%");
        }

        return $filter;
    }

    private function executeSaleFilter(Request $request): Sale|Builder {
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

        return $filter;
    }
}
