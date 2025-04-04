<?php

namespace App\Http\Controllers;

use App\Enums\ReturnMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
    public function index(Request $request): View {
        $filter = $this->executeFilter($request);

        return view('auth.receipts.list', ['receipts' => $filter->orderBy('sale_date', 'desc')->simplePaginate(10)]);
    }

    public function update(Request $request, string $uuid): RedirectResponse {
        try {
            DB::table('get_all_receipts')->where('receipt_code', '=', $uuid)->firstOrFail();
            
            DB::table('receipts')
                ->where('uuid', '=', $uuid)
                ->update(['status' => 'Paid']);

            session()->flash('success', ReturnMessage::RECEIPT_PAID_SUCCESS->value);
            return redirect()->back();
        } catch (\Exception) {
            session()->flash('error', ReturnMessage::RECEIPT_PAID_SUCCESS->value);
            return redirect()->back();

        }
    }

    public function isBrazilianDate(string $value) {
        return preg_match('/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/', $value);
    }

    private function executeFilter(Request $request): Builder {
        $filter = DB::table('get_all_receipts');

        if ($request->has('filter') AND !empty($request->query('filter'))) {
            $date = null;
            if ($this->isBrazilianDate($request->query('filter'))) {
                $date = \DateTime::createFromFormat('d/m/Y', $request->query('filter'))->format('Y-m-d');
            }

            $filter->where('customer_name', 'LIKE', "%{$request->query('filter')}%")
                ->orWhere('customer_document', 'LIKE', "%{$request->query('filter')}%")
                ->orWhere('payment_date', '=', $date ?? $request->query('filter'))
                ->orWhere('sale_date', '=', $date ?? $request->query('filter'));
        }

        return $filter;
    }
}
