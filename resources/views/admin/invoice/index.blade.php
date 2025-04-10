@extends('_layouts.master');

@section('content')
<ol class="breadcrumb mb-0">
    <li class="breadcrumb-item">Menu</li>
    <li class="breadcrumb-item active">Invoice</li>
</ol>
<h1 class="mb-3">Invoice</h1>

<hr>
<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
    <i class="fas fa-plus"></i> Tambah
</button> --}}
<a href="{{ url('invoice/create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Tambah
</a>

<table class="table table-stripted dataTable">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Kode</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoice as $item)
        <tr>
            <td>{{ $item->tanggal }}</td>
            <td>{{ $item->kode_invoice }}</td>
            <td>{{ number_format($item->total_harga_jual) }}</td>
            <td>
                <a href="{{ url('/invoice/pdf/'.$item->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-file-invoice"></i> Cetak</a>
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