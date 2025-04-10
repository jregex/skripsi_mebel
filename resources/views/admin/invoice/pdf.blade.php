<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV. IWAN MEBEL</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-number {
            font-size: 24px;
            color: #333;
        }
        .invoice-date {
            font-size: 16px;
            color: #777;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .invoice-from,
        .invoice-to {
            flex-basis: 48%;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        .invoice-table th {
            background-color: #f2f2f2;
        }
        .invoice-total {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="invoice-header">
            <div class="invoice-number">INVOICE #{{ $invoice->kode_invoice }}</div>
            <div class="invoice-date">Tanggal: {{ date('d M Y', strtotime($invoice->tanggal)) }}</div>
        </div>
        <div class="invoice-details">
            <div class="invoice-from">
                <h3>From:</h3>
                <p>CV Iwan Mebel</p>
                <p>Jl. Perintis Kemerdekaan</p>
                <p>Kota Makassar, Sulawesi Selatan</p>
            </div>
            <div class="invoice-to">
                <h3>To:</h3>
                @if ($invoice->nama == "-")
                <p>-</p>
                    
                @else
                <p>{{ $invoice->nama }}</p>
                <p>{{ $invoice->alamat }}</p>
                <p>{{ $invoice->no_hp }}</p>
                @endif
            </div>
        </div>
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->details as $item)
                <tr>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp.{{ number_format($item->harga_jual) }}</td>
                    <td>Rp.{{ number_format($item->total) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="invoice-total">Sub Total:</td>
                    <td>Rp.{{ number_format($invoice->total_harga_jual) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="invoice-total">Diskon:</td>
                    <td>Rp.{{ number_format($invoice->diskon) ?? "-" }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="invoice-total">Grand Total:</td>
                    <td>Rp.{{ number_format($invoice->total_harga_jual - $invoice->diskon) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
