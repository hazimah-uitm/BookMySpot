<!DOCTYPE html>
<html>
<head>
    <title>Tiket Tempahan Meja</title>
    <link rel="icon" href="{{ asset('assets/images/logo-icon.png') }}" type="image/png" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }
        .card-title {
            margin-bottom: 20px;
        }
        .card p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="card">
        <h4 class="card-title">Maklumat Tempahan</h4>
        <p><strong>No. Tempahan:</strong> {{ $booking->booking_no }}</p>
        <p><strong>Nama:</strong> {{ $booking->staff->name }}</p>
        <p><strong>No. Pekerja:</strong> {{ $booking->staff->no_pekerja }}</p>
        <p><strong>No. Meja:</strong> {{ $booking->table->table_no }}</p>
        <p><strong>Tarikh Tempahan:</strong> {{ $booking->created_at->format('d-m-Y H:i') }}</p>
        <p><strong>Sila tunjuk tiket ini kepada urusetia semasa datang ke Malam Gala Dinner.</strong></p>
    </div>
</body>
</html>
