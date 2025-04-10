<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Order - CV. IWAN MEBEL</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .delivery-order {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .delivery-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .delivery-number {
            font-size: 24px;
            color: #333;
        }
        .delivery-date {
            font-size: 16px;
            color: #777;
        }
        .delivery-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .delivery-from,
        .delivery-to {
            flex-basis: 48%;
        }
        .delivery-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .delivery-table th,
        .delivery-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        .delivery-table th {
            background-color: #f2f2f2;
        }
        .delivery-total {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="delivery-order">
        <div class="delivery-header">
            <div class="delivery-number">DELIVERY ORDER #{{ $delivery_order->kode_delivery_order }}</div>
            <div class="delivery-date">INVOICE: #{{ $delivery_order->kode_invoice }}</div>
            <div class="delivery-date">Tanggal Pengiriman: {{ date('d M Y', strtotime($delivery_order->tanggal_pengiriman)) }}</div>
        </div>
        <div class="delivery-details">
            <div class="delivery-from">
                <h3>From:</h3>
                <p>CV Iwan Mebel</p>
                <p>Jl. Perintis Kemerdekaan</p>
                <p>Kota Makassar, Sulawesi Selatan</p>
            </div>
            <div class="delivery-to">
                <h3>To:</h3>
                @if ($delivery_order->nama_customer == "-")
                <p>-</p>
                @else
                <p>{{ $delivery_order->nama_customer }}</p>
                <p>{{ $delivery_order->alamat }}</p>
                <p>{{ $delivery_order->no_hp }}</p>
                @endif
            </div>
        </div>
        <table class="delivery-table">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($delivery_order->details as $item)
                <tr>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->satuan }}</td>
             
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
