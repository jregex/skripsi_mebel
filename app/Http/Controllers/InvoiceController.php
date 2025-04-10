<?php

namespace App\Http\Controllers;

use App\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Invoice;
use App\InvoiceDetails;
use Barryvdh\DomPDF\Facade\Pdf;
use RealRashid\SweetAlert\Facades\Alert as FacadesAlert;

class InvoiceController extends Controller
{
    public function index()
    {
        $data['invoice'] = Invoice::latest()->get();
        return view('admin.invoice.index', $data);
    }

    public function create()
    {
        // Sistem mengecek apakah sudah ada data invoice tahun ini
        // jika masih kosong maka angka invoice dimulai dari angka 1
        // jika sudah ada maka angka invoice yaitu angka invoice terahir akan ditambahkan 1
        $invoice = Invoice::whereYear('tanggal', date('Y'))
                                ->whereMonth('tanggal', date('m'))
                                ->latest()->first();

        if ($invoice == null) {
            $invoice = 1;
        }else {
            $kode = substr($invoice->kode_invoice,12);
            $invoice = $kode + 1;
        }

        // Angka kode invoice selanjutnya ditambahkan ke kode invoice
        // Format kode invoice yaitu INV-{TAHUN}/{angka}
        $data['kode_invoice'] = "INV-" . date('Y/m/') . $invoice;

        // mengambil data detail barang yang akan dijual
        $data['invoice_detail'] = InvoiceDetails::where('kode_invoice', $data['kode_invoice'])->get();
        $data['barang'] = Barang::get();
        return view('admin.invoice.create', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_invoice' => 'required',
            'barang_id' => 'required'
        ]);

        $barang = Barang::where('id', $validated['barang_id'])->first();

        $data['kode_invoice'] = $validated['kode_invoice'];
        $data['kode_barang'] = $barang->kode;
        $data['nama_barang'] = $barang->nama;
        $data['harga_modal'] = $barang->harga_modal;
        $data['harga_jual'] = $barang->harga_jual;
        $data['jumlah'] = 1;
        $data['total'] = $barang->harga_jual;

        // cek detail invoice
        $cek = InvoiceDetails::where([
            ['kode_invoice', $validated['kode_invoice']],
            ['kode_barang', $data['kode_barang']]
        ])->first();

        if ($cek) {
            $cek->update([
                'jumlah' => 1
            ]);
        } else {
            InvoiceDetails::create($data);
        }

        return back();
    }

    public function updateJumlahPembelian(Request $request)
    {
        $validated = $request->validate([
            'invoice_detail_id' => 'required',
            'jumlah' => 'required',
            'kode_barang' => 'required'
        ]);

        $barang = Barang::where('kode', $validated['kode_barang'])->first();

        InvoiceDetails::where('id', $validated['invoice_detail_id'])->update([
            'jumlah' => $validated['jumlah'],
            'total' => $validated['jumlah'] * $barang->harga_jual,
        ]);

        return back();
    }

    public function storePenjualan(Request $request)
    {
        $validated = $request->validate([
            'kode_invoice' => 'required',
            'diskon' => '',
            'nama' => '',
            'alamat' => '',
            'no_hp' => '',
        ]);

        $dataInvoice = InvoiceDetails::where('kode_invoice', $validated['kode_invoice'])->get();

        foreach ($dataInvoice as $item) {
            Barang::where('kode', $item->kode_barang)->decrement('stok', $item->jumlah);
        }

        $data['kode_invoice'] = $validated['kode_invoice'];
        $data['diskon'] = $validated['diskon'];
        $data['nama'] = $validated['nama'];
        $data['alamat'] = $validated['alamat'];
        $data['no_hp'] = $validated['no_hp'];
        $data['tanggal'] = date('Y-m-d');
        $data['total_harga_modal'] = $dataInvoice->sum('harga_modal');
        $data['total_harga_jual'] = $dataInvoice->sum('total');
        $data['keuntungan'] = $data['total_harga_jual'] - $data['total_harga_modal'];
        Invoice::create($data);

        FacadesAlert::success('', 'Transaksi Berhasil!');

        return redirect('invoice');
    }

    public function showPdf(Invoice $invoice)
    {
        $data['invoice'] = $invoice->load(['details']);
        $pdf = Pdf::loadView('admin.invoice.pdf', $data);
        return $pdf->stream('invoice.pdf');
    }

    public function destroy($id)
    {
        $delete=InvoiceDetails::where('id',$id)->delete();
        if($delete){
            FacadesAlert::success('','data berhasil dihapus');
        }else{
            FacadesAlert::error('failed','data gagal dihapus');
        }
        return redirect()->route('invoice.create');
    }
}
