<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoicingGeneratorRequest;
use App\Services\Invoice\InvoicingGeneratorService;

class GenerateInvoicingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(InvoicingGeneratorRequest $request)
    {
        $data = $request->validated();

        $invoicingGeneratorService = new InvoicingGeneratorService();

        $dataInvoices = $invoicingGeneratorService->execute($data);

        return response()->json($dataInvoices);
    }
}
