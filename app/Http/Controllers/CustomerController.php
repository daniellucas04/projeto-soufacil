<?php

namespace App\Http\Controllers;

use App\Enums\ReturnMessage;
use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request): View {
        $filter = $this->executeFilter($request);

        return view('auth.customers.list', ['customers' => $filter->simplePaginate(10)]);
    }
    
    public function create(Request $request) {
        return view('auth.customers.create');
    }
    
    public function edit(Request $request, string $uuid) {
        return view('auth.customers.edit', ['customer' => Customer::whereUuid($uuid)->first()]);
    }

    public function store(Request $request) {
        $validated = $request->validate($this->rules(), [
            'phone.phone' => ReturnMessage::CUSTOMER_PHONE_INVALID->value
        ]);

        try {
            Customer::create($validated);

            session()->flash('success', ReturnMessage::CUSTOMER_CREATED_SUCCESS->value);
            return redirect('/customers');
        } catch (\Exception) {
            session()->flash('error', ReturnMessage::CUSTOMER_CREATED_FAIL->value);
            return redirect('/customers');
        }
    }

    public function update(Request $request, string $uuid) {
        $validated = $request->validate($this->rules($uuid), [
            'phone.phone' => ReturnMessage::CUSTOMER_PHONE_INVALID->value
        ]);

        try {
            $customer = Customer::whereUuid($uuid)->firstOrFail();
            $customer->update($validated);

            session()->flash('success', ReturnMessage::CUSTOMER_UPDATED_SUCCESS->value);
            return redirect('/customers');
        } catch (\Exception) {
            session()->flash('error', ReturnMessage::CUSTOMER_UPDATED_FAIL->value);
            return redirect('/customers');
        }
    }
    
    public function destroy(Request $request, string $uuid) {
        try {
            $customer = Customer::whereUuid($uuid)->firstOrFail();
            $customer->delete();

            session()->flash('success', 'Customer deleted successfully!');
            return redirect('/customers');
        } catch (\Exception) {
            session()->flash('error', 'Cannot delete the customer. Try again.');
            return redirect('/customers');
        }
    }

    private function rules(?string $uuid = null) {
        $rules = [
            'name' => 'required|string|max:255',
            'cpf_cnpj' => 'required|string|max:255',
            'phone' => 'required|phone:BR',
            'email' => ['required', 'email', 'unique:customers'],
        ];
    
        if (!empty($uuid)) {
            $rules['email'] = array_slice($rules['email'], 0, 2);
        }

        return $rules;
    }

    private function executeFilter(Request $request): Customer|Builder {
        $filter = Customer::query();

        if ($request->has('filter') AND !empty($request->query('filter'))) {
            $filter->where('name', 'LIKE', "%{$request->query('filter')}%")
                ->orWhere('cpf_cnpj', 'LIKE', "%{$request->query('filter')}%");
        }

        return $filter;
    }
}
