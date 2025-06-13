<?php

namespace App\Services;

use App\Models\Vente;

interface VenteService
{
    public function create(array $data): Vente;
    public function update(Vente $vente, array $data): Vente;
    public function generateInvoiceNumber(): string;
    // public function generateInvoicePdf(Vente $vente): string;
    public function genererOuTelechargerFacture(Vente $vente);

    


}
