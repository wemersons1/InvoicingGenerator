<?php

namespace App\Services\Invoice;

use Illuminate\Support\Facades\DB;

class CreateInvoicesService {

    public function execute($invoicesWithContract)
    {
        return DB::table('invoices')->insert($invoicesWithContract);
    }

}
