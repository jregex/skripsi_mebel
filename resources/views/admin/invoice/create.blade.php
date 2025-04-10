@extends('_layouts.master');

@section('content')
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">Menu</li>
        <li class="breadcrumb-item active">Invoice</li>
    </ol>
    <h1 class="mb-3">Invoice</h1>

    <hr>

    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-4">

                    <div class="mb-3">
                        <label for="">Tanggal</label>
                        <input type="date" class="form-control rounded-0" name="tanggal" value="{{ date('Y-m-d') }}"
                            readonly>
                    </div>

                </div>
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
                        <label for="">Kode Invoice</label>
                        <input type="text" class="form-control rounded-0" name="kode_invoice" value="{{ $kode_invoice }}"
                            readonly>
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
                                <th class="text-center">Harga</th>
                                <th class="text-center">Jumlah Pembelian</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice_detail as $item)
                                <tr>
                                    <td class="text-center align-middle">{{ $item->kode_barang }}</td>
                                    <td class="text-center align-middle">{{ $item->nama_barang }}</td>
                                    <td class="text-end align-middle">{{ number_format($item->harga_jual) }}</td>
                                    <td class="text-center align-middle" style="width: 250px">
                                        <form action="{{ url('invoice/update') }}" method="post"
                                            enctype="multipart/form-data" class="m-0 simpan">
                                            @csrf
                                            @method('patch')
                                            <input type="hidden" value="{{ $item->id }}" name="invoice_detail_id">
                                            <input type="hidden" value="{{ $item->kode_barang }}" name="kode_barang">
                                            <input type="number" name="jumlah" class="align-middle text-center jumlah"
                                                style="width: 50px" value="{{ $item->jumlah }}">
                                            {{-- <button class="btn btn-sm btn-secondary" type="submit">
                                        <i class="fas fa-edit"></i>
                                    </button> --}}
                                        </form>
                                    </td>
                                    <td class="text-end align-middle">{{ number_format($item->total) }}</td>
                                    <td class="text-center align-center">
                                        <form action="{{ route('invoice.delete', $item->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger">
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
                        Informasi Pembayaran
                        <hr>
                    </div>
                    <div class="mb-3">
                        <label for="" class="fw-bold">Sub Total</label>
                        <input type="text" class="form-control rounded-0" disabled
                            value="Rp. {{ number_format($invoice_detail->sum('total')) }}">
                    </div>

                    <div class="mb-3"> <label for="" class="fw-bold">Diskon</label>
                        <input type="text" class="form-control rounded-0" id="diskon" value="">
                    </div>

                    <div class="alert alert-success rounded-0">
                        <label for="" class="fw-bold">Grand Total</label>
                        <h3 class="text-center">Rp. <span
                                id="grandTotal">{{ number_format($invoice_detail->sum('total')) }}</span></h3>
                    </div>
                    <form action="{{ url('invoice') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="fw-bold">Nama Customer</label>
                            <input type="text" name="nama" class="form-control rounded-0" value="-">
                        </div>
                        <div class="mb-3">
                            <label for="" class="fw-bold">Alamat Customer</label>
                            <input type="text" name="alamat" class="form-control rounded-0" value="-">
                        </div>
                        <div class="mb-3">
                            <label for="" class="fw-bold">No HP Customer</label>
                            <input type="text" name="no_hp" class="form-control rounded-0" value="-">
                        </div>

                        <input type="hidden" name="kode_invoice" value="{{ $kode_invoice }}">
                        <input type="hidden" name="diskon" id="inputDiskon">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary rounded-0 mt-3">
                                <i class="fas fa-check"></i>
                                Buat Transaksi
                            </button>
                            <a href="{{ route('invoice.index') }}" class="btn">
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
                                {{-- <th>Kode</th> --}}
                                <th class="text-center">Nama</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang as $item)
                                <tr>
                                    {{-- <td>{{ $item->kode }}</td> --}}
                                    <td class="align-middle text-center">{{ $item->nama }}</td>
                                    <td class="align-middle text-end">{{ number_format($item->harga_jual) }}</td>
                                    <td class="align-middle text-center">{{ $item->stok }}</td>
                                    <td class="align-middle text-center">
                                        <form action="" method="post" class="mb-0">
                                            @csrf
                                            <input type="hidden" value="{{ $kode_invoice }}" name="kode_invoice">
                                            <input type="hidden" value="{{ $item->id }}" name="barang_id">
                                            <button class="btn btn-primary btn-sm mb-0">
                                                <i class="fas fa-cart-plus"></i>
                                                Beli
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            };

            function isNumber(evt) {
                var theEvent = evt || window.event;
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
                if (key.length == 0) return;
                var regex = /^[0-9.,\b]+$/;
                if (!regex.test(key)) {
                    theEvent.returnValue = false;
                    if (theEvent.preventDefault) theEvent.preventDefault();
                }
            }

            $('#diskon').keyup(function() {
                $(this).mask("###,###,###,###,###", {
                    reverse: true
                });
                isNumber();
                var diskon, grandTotal;
                diskon = $(this).val().replace(/,/g, '');
                grandTotal = parseInt({{ $invoice_detail->sum('total') }} * diskon);
                $('#inputDiskon').val(diskon);
                $('#grandTotal').text(numberWithCommas(grandTotal));
            });

            $('.jumlah').blur(function() {
                $(this).closest('.simpan').submit();
            });
        })
    </script>
@endsection
