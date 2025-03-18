<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Billet - {{ $platform_name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
        }
        .ticket {
            border: 2px solid #000;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .event-details {
            margin-bottom: 30px;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        .qr-code img {
            max-width: 200px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1>{{ $platform_name }}</h1>
            <p>{{ $platform_slogan }}</p>
        </div>

        <div class="event-details">
            <h2>{{ $ticket->event->title }}</h2>
            <p><strong>Date:</strong> {{ $ticket->event->start_date->format('d/m/Y H:i') }}</p>
            <p><strong>Lieu:</strong> {{ $ticket->event->location }}</p>
            <p><strong>Type de billet:</strong> {{ $ticket->type }}</p>
            <p><strong>Prix:</strong> {{ number_format($ticket->price, 0, ',', ' ') }} FCFA</p>
            <p><strong>Code unique:</strong> {{ $ticket->unique_code }}</p>
        </div>

        <div class="qr-code">
            <img src="{{ $qr_code }}" alt="QR Code">
        </div>

        <div class="footer">
            <p>{{ $thank_you_message }}</p>
            <p>Date d'achat: {{ $purchase_date }}</p>
        </div>
    </div>
</body>
</html>
