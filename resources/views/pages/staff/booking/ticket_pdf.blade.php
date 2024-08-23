<!DOCTYPE html>
<html>

<head>
    <title>Tiket Tempahan Meja</title>
    <link rel="icon" href="{{ asset('public/assets/images/logo-icon.png') }}" type="image/png" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #fff;
            background-color: #000;
            border: 2px solid #000;
            border-radius: 10px;
        }

        .wrapper-main {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
        }

        .ticket-card {
            border-radius: 15px;
            background-color: #000;
            padding: 15px;
            color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .ticket-header {
            padding: 10px 0;
            border-bottom: 1px solid #ccc;
            color: #fff;
            text-align: center;
        }

        .ticket-info h5 {
            color: #fff;
            margin-bottom: 10px;
        }

        .ticket-info th {
            width: 40%;
            color: #ccc;
        }

        .ticket-info td {
            color: #fff;
        }

        .ticket-footer {
            padding: 10px 0;
            border-top: 1px solid #ccc;
            margin-top: 20px;
            color: #fff;
            text-align: center;
            margin-bottom: 3px;
        }

        .qr-code-container {
            text-align: center;
            margin: 5px 0;
            border-radius: 10px;
        }

        .qr-code {
            border: 2px solid #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .qr-code-container img {
            width: 300px;
            /* Increased width */
            height: auto;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 10px;
            vertical-align: top;
            text-align: left;
            font-size: 16px;
        }

        table th {
            color: #ccc;
        }

        table td {
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="wrapper-main">
        <div class="ticket-card">
            <div class="ticket-header">
                <h3>TIKET MALAM GALA</h3>
            </div>
            <div class="ticket-info">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th>NO. MEJA</th>
                        <td style="font-weight:bold">{{ $booking->table->table_no }}</td>
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
            <div class="ticket-footer">
                <em>Sila imbas kod QR ini kepada urusetia semasa hadir ke Malam Gala 25 Tahun UiTM</em>
            </div>
            <div class="qr-code-container">
                <img src="{{ $booking->qr_code }}" alt="QR Code" class="qr-code">
            </div>
        </div>
    </div>
</body>

</html>