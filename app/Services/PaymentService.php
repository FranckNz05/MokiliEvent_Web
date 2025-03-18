<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PaymentService
{
    public function processPayment(Payment $payment)
    {
        // Simulation de l'appel à l'API de paiement
        // À remplacer par l'intégration réelle avec l'API de paiement
        return $this->simulatePaymentGateway();
    }

    public function verifyPayment(Payment $payment)
    {
        // Simulation de la vérification du paiement
        // À remplacer par l'intégration réelle avec l'API de paiement
        return $this->simulatePaymentGateway();
    }

    public function generateQrCode(string $data)
    {
        $filename = uniqid() . '.svg';
        $path = storage_path('app/public/qrcodes/' . $filename);

        // Créer le dossier s'il n'existe pas
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        QrCode::size(300)
            ->format('svg')
            ->generate($data, $path);

        return 'storage/qrcodes/' . $filename;
    }

    private function simulatePaymentGateway()
    {
        // Simulation d'une réponse de l'API de paiement
        // 80% de chance de succès
        return rand(1, 100) <= 80;
    }
}
