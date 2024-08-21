<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListInvoicingRequest;
use App\Services\Invoice\ListInvoicesByContractIdService;
use Illuminate\Http\Request;

class InvoicingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ListInvoicingRequest $request)
    {
        $data = $request->validated();

        if(isset($data['id'])) {
            $listInvoicesByContractIdService = new ListInvoicesByContractIdService();
            $listInvoices = $listInvoicesByContractIdService->execute($data['id']);
        }

        return $listInvoices;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
