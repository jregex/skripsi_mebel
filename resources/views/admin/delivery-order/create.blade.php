@extends('_layouts.master');

@section('content')
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">Menu</li>
        <li class="breadcrumb-item active">Delivery Order</li>
    </ol>
    <h1 class="mb-3">Delivery Order</h1>

    <hr>

    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-4">

                    <label for="">Kode Barang</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control rounded-0" name="kode_barang" placeholder="kode barang"
                            readonly>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                </div>
                <div class="col-lg-4">

                    <div class="mb-3">
                        <label for="">Kode Delivery Order</label>
                        <input type="text" class="form-control rounded-0" name="kode_delivery_order"
                            value="{{ $kode_delivery_order }}" readonly>
                    </div>

                </div>
            </div>

            <div class="card mb-4 shadow" style="height: 58vh">
                <div class="card-body">

                    <table class="table table-bordered table-sm table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Kode</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jumlah Pembelian</th>
                                <th class="text-center">Satuan</th>
                                <th class="text-center">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($delivery_order_detail as $item)
                                <tr>
                                    <td class="text-center align-middle">{{ $item->kode_barang }}</td>
                                    <td class="text-center align-middle">{{ $item->nama_barang }}</td>
                                    <td class="text-center align-middle" style="width: 250px">
                                        <form action="{{ url('invoice/update') }}" method="post"
                                            enctype="multipart/form-data" class="m-0 simpan">
                                            @csrf
                                            @method('patch')
                                            <input type="hidden" value="{{ $item->id }}"
                                                name="delivery_order_detail_id">
                                            <input type="hidden" value="{{ $item->kode_barang }}" name="kode_barang">
                                            <input type="number" name="jumlah" class="align-middle text-center jumlah"
                                                style="width: 50px" value="{{ $item->jumlah }}">

                                        </form>
                                    </td>
                                    <td class="text-center align-middle">{{ $item->satuan }}</td>
                                    <td class="text-center align-center">
                                        <form action="{{ route('deliveryorder.delete', $item->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="card rounded-0 shadow">
                <div class="card-body">
                    <div class="h3">
                        Informasi Pengiriman
                        <hr>
                    </div>
                    <form action="{{ url('delivery-order') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="">Tanggal Pengiriman</label>
                            <input type="date" class="form-control rounded-0" name="tanggal_pengiriman"
                                value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="fw-bold">Kode Invoice</label>
                            <input type="text" name="kode_invoice" class="form-control rounded-0" value="-"
                                required>
                        </div>


                        <div class="mb-3">
                            <label for="" class="fw-bold">Nama Customer</label>
                            <input type="text" name="nama_customer" class="form-control rounded-0" value="-">
                        </div>
                        <div class="mb-3">
                            <label for="" class="fw-bold">Alamat Customer</label>
                            <input type="text" name="alamat" class="form-control rounded-0" value="-">
                        </div>
                        <div class="mb-3">
                            <label for="" class="fw-bold">No HP Customer</label>
                            <input type="text" name="no_hp" class="form-control rounded-0" value="-">
                        </div>

                        <input type="hidden" name="kode_delivery_order" value="{{ $kode_delivery_order }}">

                        <div class="d-grid gap-2">
                            <button class="btn btn-primary rounded-0 mt-3">
                                <i class="fas fa-check"></i>
                                Buat Delivery Order
                            </button>
                            <a href="{{ route('deliveryorder.index') }}" class="btn ">
                                <i class="fas fa-times"></i>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Barang -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="alert alert-info">Barang yang tampil adalah barang yang memiliki stok > 0</div>
                    <table class="table table-bordered dataTable table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">Kode Barang</th>
                                <th class="text-center">Nama Barang</th>
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
                                    <td class="align-middle text-center">{{ $item->stok }}</td>
                                    <td class="align-middle text-center">{{ $item->satuan }}</td>
                                    <td class="align-middle text-center">
                                        <form action="" method="post" class="mb-0">
                                            @csrf
                                            <input type="hidden" value="{{ $kode_delivery_order }}"
                                                name="kode_delivery_order">
                                            <input type="hidden" value="{{ $item->id }}" name="barang_id">
                                            <button class="btn btn-primary btn-sm mb-0">
                                                <i class="fas fa-plus"></i>
                                                Add
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fas fa-times"></i>
                        Close</button>
                    {{-- <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
