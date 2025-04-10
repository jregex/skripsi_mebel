@extends('_layouts.master');

@section('content')
<ol class="breadcrumb mb-0">
    <li class="breadcrumb-item">Menu</li>
    <li class="breadcrumb-item active">Data Barang</li>
</ol>
<h1 class="mb-3">Data Barang</h1>

<hr>
 <!-- Button trigger modal -->
 <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
    <i class="fas fa-plus"></i> Tambah
</button>

<table class="table dataTable">
    <thead>
        <tr>
            <th class="text-center">Kode</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Harga Modal</th>
            <th class="text-center">Harga Jual</th>
            <th class="text-center">Stok</th>
            <th class="text-center">Satuan</th>
            <th class="text-center">#</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barang as $item)
            <tr>
                <td class="align-middle text-center">{{ $item->kode }}</td>
                <td class="align-middle text-center">{{ $item->nama }}</td>
                <td class="align-middle text-center">{{ number_format($item->harga_modal) }}</td>
                <td class="align-middle text-center">{{ number_format($item->harga_jual) }}</td>
                <td class="align-middle text-center">{{ number_format($item->stok) }}</td>
                <td class="align-middle text-center">{{ $item->satuan }}</td>
                <td>
                    <form action="" method="post" enctype="multipart/form-data" class="mb-0"> 

                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>

</table>

<!-- Modal Tambah Barang -->
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
                        <input type="text" class="form-control rounded-0" name="kode" value="{{ $kode_barang }}" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="">Nama Barang</label>
                        <input type="text" class="form-control rounded-0" name="nama" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="">Harga Modal</label>
                        <input type="number" class="form-control rounded-0" name="harga_modal" value="0" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="">Harga Jual</label>
                        <input type="number" class="form-control rounded-0" name="harga_jual" value="0" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="">Stok</label>
                        <input type="number" class="form-control rounded-0" name="stok" required value="0" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="">Satuan</label>
                        <input type="text" class="form-control rounded-0" value="set" name="satuan" required>
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