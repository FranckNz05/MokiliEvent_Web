<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Billet - {{ $event->title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .ticket {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 20px;
        }
        .event-title {
            font-size: 24px;
            color: #0d6efd;
            margin-bottom: 10px;
        }
        .ticket-info {
            margin-bottom: 30px;
        }
        .info-row {
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
            color: #666;
        }
        .qr-code {
            text-align: center;
            margin-top: 30px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .matricule {
            text-align: center;
            font-size: 18px;
            color: #0d6efd;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1 class="event-title">{{ $event->title }}</h1>
            <p>{{ $event->category->name }}</p>
        </div>

        <div class="ticket-info">
            <div class="info-row">
                <span class="label">Type de billet :</span>
                <span>{{ $ticket->nom }}</span>
            </div>
            <div class="info-row">
                <span class="label">Date :</span>
                <span>{{ $event->start_date->format('d/m/Y à H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="label">Lieu :</span>
                <span>{{ $event->adresse }}, {{ $event->ville }}</span>
            </div>
            <div class="info-row">
                <span class="label">Quantité :</span>
                <span>{{ $payment->reservation ? $payment->reservation->quantity : 1 }}</span>
            </div>
            <div class="info-row">
                <span class="label">Prix total :</span>
                <span>{{ number_format($payment->montant, 0, ',', ' ') }} XAF</span>
            </div>
            <div class="info-row">
                <span class="label">Acheteur :</span>
                <span>{{ $payment->user->prenom }} {{ $payment->user->nom }}</span>
            </div>
        </div>

        <div class="matricule">
            N° {{ $payment->matricule }}
        </div>

        <div class="qr-code">
            {!! $qrCode !!}
        </div>

        <div class="footer">
            <p>Ce billet est personnel et ne peut être revendu. Présentez-le à l'entrée de l'événement.</p>
            <p>Pour toute question, contactez l'organisateur : {{ $event->organizer->email }}</p>
        </div>
    </div>
</body>
</html>
```