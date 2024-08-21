<!DOCTYPE html>
<html>

<head>
    <title>Tiket Tempahan Meja</title>
    <link rel="icon" href="{{ asset('assets/images/logo-icon.png') }}" type="image/png" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #333;
        }

        .card {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            margin-bottom: 20px;
            font-size: 24px;
            color: #007bff;
        }

        .table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 10px;
            vertical-align: top;
            text-align: left;
            font-size: 16px;
        }

        .table th {
            width: 30%;
            color: #000;
        }

        .note {
            padding: 15px;
            background-color: #e9f7ff;
            border-left: 4px solid #007bff;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="card">
        <h4 class="card-title">Maklumat Tempahan</h4>
        <table class="table table-borderless">
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
            <tr>
                <th>TARIKH TEMPAHAN</th>
                <td>{{ $booking->created_at->format('d-m-Y H:i') }}</td>
            </tr>
        </table>
        <div class="note">
            <p><strong>Nota:</strong> Sila tunjuk tiket ini kepada urusetia semasa datang ke Malam Gala Dinner.</p>
        </div>
    </div>
</body>

</html>