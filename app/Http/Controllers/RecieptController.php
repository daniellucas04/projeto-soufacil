<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecieptController extends Controller
{
    public function index(Request $request): View {
        $filter = DB::table('get_all_reciepts');

        if ($request->has('filter') AND !empty($request->query('filter'))) {
            $date = null;
            if (preg_match('/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/', $request->query('filter'))) {
                $date = \DateTime::createFromFormat('d/m/Y', $request->query('filter'))->format('Y-m-d');
            }

            $filter->where('customer_name', 'LIKE', "%{$request->query('filter')}%")
                ->orWhere('customer_document', 'LIKE', "%{$request->query('filter')}%")
                ->orWhere('payment_date', '=', $date ?? $request->query('filter'))
                ->orWhere('sale_date', '-', $date ?? $request->query('filter'));
        }

        return view('auth.reciepts.list', ['reciepts' => $filter->simplePaginate(10)]);
    }

    public function update(Request $request, string $uuid): RedirectResponse {
        try {
            $reciept = DB::table('get_all_reciepts')->where('reciept_code', '=', $uuid)->firstOrFail();
            
            DB::table('reciepts')
                ->where('uuid', '=', $uuid)
                ->update(['status' => 'Paid']);

            session()->flash('success', "The reciept of the customer {$reciept->customer_name} has been paid!");
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', "Cannot paid the reciept for this customer. Try again!");
            return redirect()->back();

        }
    }
}
