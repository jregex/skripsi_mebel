@extends('_layouts.master');

@section('content')
<ol class="breadcrumb mb-0">
    <li class="breadcrumb-item">Menu</li>
    <li class="breadcrumb-item active">Delivery Order</li>
</ol>
<h1 class="mb-3">Delivery Order</h1>

<hr>

<a href="{{ url('delivery-order/create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Tambah
</a>

<table class="table table-stripted dataTable">
    <thead>
        <tr>
            <th>Tanggal Pengiriman</th>
            <th>Kode Delivery Order</th>
            <th>Kode Invoice</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($delivery_order as $item)
        <tr>
            <td>{{ date('d-m-Y', strtotime($item->tanggal_pengiriman)) }}</td>
            <td>{{ $item->kode_delivery_order }}</td>
            <td>{{ $item->kode_invoice }}</td>
            <td>{{ $item->nama_customer }}</td>
            <td>{{ $item->alamat }}</td>
            <td>{{ $item->no_hp }}</td>
            <td>
                <a href="{{ url('/delivery-order/pdf/'.$item->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-file-invoice"></i> Cetak</a>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Kode Barang</label>
                        <input type="text" class="form-control rounded-0" name="kode">
                    </div>
                    <div class="mb-3">
                        <label for="">Nama Barang</label>
                        <input type="text" class="form-control rounded-0" name="nama">
                    </div>
                    <div class="mb-3">
                        <label for="">Harga</label>
                        <input type="number" class="form-control rounded-0" name="harga">
                    </div>
                    <div class="mb-3">
                        <label for="">Stok</label>
                        <input type="number" class="form-control rounded-0" name="stok">
                    </div>
                    <div class="mb-3">
                        <label for="">Satuan</label>
                        <input type="text" class="form-control rounded-0" name="satuan">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection