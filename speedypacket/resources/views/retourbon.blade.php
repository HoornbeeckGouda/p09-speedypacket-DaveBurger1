<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retourbon - {{ $package->tracking_number }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #dc2626;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #dc2626;
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .content {
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section h2 {
            color: #dc2626;
            font-size: 18px;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table th, .info-table td {
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .info-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            width: 30%;
        }
        .footer {
            border-top: 2px solid #dc2626;
            padding-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 10px;
        }
        .tracking-code {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 16px;
            font-weight: bold;
            color: #2563eb;
            display: inline-block;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">SpeedyPacket</div>
        <h1>Retourbon</h1>
        <p>Officiële retourdocumentatie</p>
        <div class="tracking-code">{{ $package->tracking_number }}</div>
    </div>

    <div class="content">
        <div class="section">
            <h2>Retour Informatie</h2>
            <table class="info-table">
                <tr>
                    <th>Retour Datum:</th>
                    <td>{{ $package->updated_at->format('d-m-Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Retour Status:</th>
                    <td>Geïnitieerd</td>
                </tr>
                <tr>
                    <th>Verwerkingsstatus:</th>
                    <td>In behandeling</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2>Pakket Details</h2>
            <table class="info-table">
                <tr>
                    <th>Tracking Nummer:</th>
                    <td>{{ $package->tracking_number }}</td>
                </tr>
                <tr>
                    <th>Beschrijving:</th>
                    <td>{{ $package->description ?? 'Geen beschrijving beschikbaar' }}</td>
                </tr>
                <tr>
                    <th>Gewicht:</th>
                    <td>{{ $package->weight ? $package->weight . ' kg' : 'Niet gespecificeerd' }}</td>
                </tr>
                <tr>
                    <th>Oorspronkelijke Status:</th>
                    <td>{{ ucfirst(str_replace('_', ' ', $package->status)) }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2>Verzender Informatie</h2>
            <table class="info-table">
                <tr>
                    <th>Naam:</th>
                    <td>{{ $package->user->name ?? 'Onbekend' }}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{ $package->user->email ?? 'Onbekend' }}</td>
                </tr>
                <tr>
                    <th>Telefoon:</th>
                    <td>{{ $package->user->phone ?? 'Niet beschikbaar' }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2>Ontvanger Informatie</h2>
            <table class="info-table">
                <tr>
                    <th>Naam:</th>
                    <td>{{ $package->recipient_name }}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{ $package->recipient_email }}</td>
                </tr>
                <tr>
                    <th>Telefoon:</th>
                    <td>{{ $package->recipient_phone ?? 'Niet beschikbaar' }}</td>
                </tr>
                <tr>
                    <th>Adres:</th>
                    <td>{{ $package->recipient_address }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2>Retour Instructies</h2>
            <p>Deze retourbon bevestigt dat uw retourverzoek is ontvangen en wordt verwerkt. Het pakket zal worden opgehaald door een koerier van SpeedyPacket.</p>
            <p><strong>Belangrijke informatie:</strong></p>
            <ul>
                <li>Bewaar deze retourbon voor uw administratie</li>
                <li>Het pakket moet klaar staan voor ophaling</li>
                <li>U ontvangt een bevestiging per email zodra het pakket is opgehaald</li>
                <li>Retourkosten worden berekend volgens onze tarieven</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p>SpeedyPacket - Snelle en betrouwbare pakketbezorging</p>
        <p>Document gegenereerd op {{ now()->format('d-m-Y H:i:s') }}</p>
        <p>Voor vragen: support@speedypacket.nl | +31 (0) 20 123 4567</p>
    </div>
</body>
</html>
