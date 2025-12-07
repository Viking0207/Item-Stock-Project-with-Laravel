<!DOCTYPE html>
<html>

<head>
    <title>Struk Pembelian</title>
    <style>
        body {
            font-family: monospace;
            width: 280px;
        }

        h3,
        p {
            text-align: center;
            margin: 5px 0;
        }

        table {
            width: 100%;
        }

        td {
            padding: 3px 0;
        }

        .total {
            border-top: 1px dashed #000;
            margin-top: 8px;
            padding-top: 5px;
            font-weight: bold;
        }
    </style>
</head>

<body onload="window.print()">

    <h3>TOKO ANDA</h3>
    <p>{{ now() }}</p>

    <table>
        @foreach ($details as $item)
            <tr>
                <td>{{ $item->nama_barang }}</td>
                <td align="right">{{ $item->qty }} x {{ number_format($item->harga) }}</td>
            </tr>
        @endforeach
    </table>

    <div class="total">
        TOTAL: Rp {{ number_format($transaksi->grand_total) }}
    </div>

    <p>Terima Kasih</p>

</body>

</html>
