<?php

namespace App\Services\Invoice;

use App\Services\Contract\CreateContractService;
use Carbon\Carbon;

class InvoicingGeneratorService {
    private $invoices = [];

    public function execute($data)
    {
        $invoices = $this->getInvoices($data);
        $invoicesWithContract = $this->getInvoicesWithContract($invoices);

        $createInvoicesService = new CreateInvoicesService();
        $createInvoicesService->execute($invoicesWithContract);

        return [
            "total" => (float) $data['valor_total'],
            "valor_entrada" => isset($data['valor_entrada']) ? (float) $data['valor_entrada'] : 0,
            "parcelas" => $invoices
        ];
    }

    private function getInvoices($data)
    {
        $hasPaymentEntry = isset($data['valor_entrada']);

        if($hasPaymentEntry) {
            $today = date('Y-m-d');
            $numberInvoicing = count($this->invoices) + 1;
            $this->invoices[] = [
                "data_vencimento" => $today,
                "valor" => (float) number_format($data['valor_entrada'], 2),
                "numero" => $numberInvoicing,
                "entrada" => true
            ];
        }

        $quantityInvoicesToGenerate = $this->getQuantityInvoicesToGenerate($data['qtd_parcelas'], $hasPaymentEntry);

        $this->generateInvoices($data, $quantityInvoicesToGenerate);

        return $this->invoices;
    }

    private function generateInvoices($data, $quantityInvoicesToGenerate)
    {
        for ($i = 0; $i < $quantityInvoicesToGenerate; $i ++) {
            $numberInvoicing = count($this->invoices) + 1;
            $this->invoices[] = [
                "data_vencimento" => $this->getDueDate($data['data_primeiro_vencimento'], $data['periodicidade'], $i),
                "valor" => $this->getValue($data, $i + 1 == $quantityInvoicesToGenerate),
                "numero" => $numberInvoicing,
                "entrada" => false
            ];
        }

        return;
    }

    private function getQuantityInvoicesToGenerate($quantityInstallments, $hasPaymentEntry)
    {
        return $hasPaymentEntry ? $quantityInstallments - 1 : $quantityInstallments;
    }

    private function getDueDate($dueDate, $periodicity, $incrementPeriodicity)
    {
        if($incrementPeriodicity) {
            [$year, $month, $day] = explode('-', $dueDate);

            $carbonDate = Carbon::create($year, (int)$month, (int)$day);

            $periodicitiesToAdd = [
                'semanal' => $carbonDate->addWeek($incrementPeriodicity)->format('Y-m-d'),
                'mensal' =>  $carbonDate->addMonth($incrementPeriodicity)->format('Y-m-d')
            ];

            return $periodicitiesToAdd[$periodicity];
        }

        return $dueDate;
    }

    private function getValue($data, $lastInvoicingToGenerate)
    {
        $hasPaymentEntry = isset($data['valor_entrada']);
        $totalValue = $data['valor_total'];

        if($hasPaymentEntry) {
            $totalValue = $totalValue - $data['valor_entrada'];
        }

        if($lastInvoicingToGenerate) {

            return $this->getTotalInvoicesGenerated($data['valor_total']);
        }

        $quantityInvoicesToGenerate = $this->getQuantityInvoicesToGenerate($data['qtd_parcelas'], $hasPaymentEntry);

        return (float) number_format($totalValue / $quantityInvoicesToGenerate, 2);
    }

    private function getTotalInvoicesGenerated($totalValue)
    {
        $totalInvoicesGenerated = collect($this->invoices)
                                    ->sum('valor');

        return (float) number_format($totalValue - (float) $totalInvoicesGenerated, 2);
    }

    private function getInvoicesWithContract($invoices)
    {
        $createContractService = new CreateContractService();
        $contract = $createContractService->execute();

        $invoicesWithContract = [];

        foreach($invoices as $invoice) {
            $invoice['contract_id'] = $contract->id;
            $invoicesWithContract[] = $invoice;
        }

        return $invoicesWithContract;
    }
}
