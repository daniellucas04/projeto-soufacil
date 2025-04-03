<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request): View {
        $filter = Customer::query();

        if ($request->has('filter') AND !empty($request->query('filter'))) {
            $filter->where('name', 'LIKE', "%{$request->query('filter')}%")
                ->orWhere('cpf_cnpj', 'LIKE', "%{$request->query('filter')}%");
        }

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
            'phone.phone' => 'The phone field contains an invalid number'
        ]);

        try {
            Customer::create($validated);

            session()->flash('success', 'Customer created successfully!');
            return redirect()->back();
        } catch (\Exception) {
            session()->flash('error', 'Cannot create the customer. Try again.');
            return redirect()->back();
        }
    }

    public function update(Request $request, string $uuid) {
        $validated = $request->validate($this->rules($uuid), [
            'phone.phone' => 'The phone field contains an invalid number'
        ]);

        try {
            $customer = Customer::whereUuid($uuid)->firstOrFail();
            $customer->update($validated);

            session()->flash('success', 'Customer updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
    
    public function destroy(Request $request, string $uuid) {
        try {
            $customer = Customer::whereUuid($uuid)->firstOrFail();
            $customer->delete();

            session()->flash('success', 'Customer deleted successfully!');
            return redirect()->back();
        } catch (\Exception) {
            session()->flash('error', 'Cannot delete the customer. Try again.');
            return redirect()->back();
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
}
