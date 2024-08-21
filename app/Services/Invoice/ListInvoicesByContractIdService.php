<?php

namespace App\Services\Invoice;

use App\Models\Invoicing;
use Illuminate\Support\Facades\DB;

class ListInvoicesByContractIdService {

    public function execute($contractId)
    {
        $invoices = Invoicing::where('contract_id', $contractId)
                                ->get();

        return $invoices;
    }
}
