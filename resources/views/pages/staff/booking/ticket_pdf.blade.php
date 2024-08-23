<!DOCTYPE html>
<html>

<head>
    <title>Tiket Tempahan Meja</title>
    <link rel="icon" href="{{ asset('public/assets/images/logo-icon.png') }}" type="image/png" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #000;
        }

        .ticket-wrapper {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            background-color: #000;
            color: #fff;
            border-radius: 15px;
            border: 3px solid #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .ticket-header {
            text-align: center;
            border-bottom: 2px groove #fff;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .ticket-header img {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        .ticket-header h3 {
            font-size: 24px;
            margin: 0;
            color: #fff;
        }

        .ticket-info {
            margin-bottom: 20px;
        }

        .ticket-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .ticket-info th,
        .ticket-info td {
            padding: 10px;
            text-align: left;
            font-size: 18px;
        }

        .ticket-info th {
            width: 40%;
            color: #ccc;
        }

        .ticket-info td {
            font-weight: bold;
            color: #fff;
        }

        .ticket-footer {
            text-align: center;
            margin-bottom: 20px;
            font-size: 16px;
            color: #ccc;
        }

        .qr-code-container {
            text-align: center;
        }

        .qr-code-container img {
            width: 330px;
            height: auto;
            display: block;
            margin: 0 auto;
            border: 2px solid #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .perforated-line {
            width: 100%;
            border-bottom: 2px groove #fff;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="ticket-wrapper">
        <div class="ticket-header">
            <img src="{{ $logoBase64 }}" alt="Logo Malam Gala" style="height: 110px; width: auto;">
        </div>

        <div class="ticket-info">
            <table>
                <tr>
                    <th>NO. MEJA</th>
                    <td>{{ $booking->table->table_no }}</td>
                </tr>
                <tr>
                    <th>NAMA</th>
                    <td>{{ $booking->staff->name }}</td>
                </tr>
                <tr>
                    <th>NO. PEKERJA</th>
                    <td>{{ $booking->staff->no_pekerja }}</td>
                </tr>
                <tr>
                    <th>NO. TEMPAHAN</th>
                    <td>{{ $booking->booking_no }}</td>
                </tr>
            </table>
        </div>

        <div class="perforated-line"></div>
        <div class="ticket-footer">
            <em>Sila imbas kod QR ini kepada urusetia semasa hadir ke Malam Gala 25 Tahun UiTM</em>
        </div>


        <div class="qr-code-container">
            <img src="{{ $booking->qr_code }}" alt="QR Code">
        </div>
    </div>
</body>

</html>
