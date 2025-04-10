<?php

namespace App\Http\Controllers;

use App\Barang;
use App\DeliveryOrder;
use App\DeliveryOrderDetails;
use App\InvoiceDetails;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;


class DeliveryOrderController extends Controller
{
    public function index()
    {
        $data['delivery_order'] = DeliveryOrder::latest()->get();
        return view('admin.delivery-order.index', $data);
    }

    public function create()
    {
        // Sistem mengecek apakah sudah ada data delivery_order tahun ini
        // jika masih kosong maka angka delivery_order dimulai dari angka 1
        // jika sudah ada maka angka delivery_order yaitu angka delivery_order terahir akan ditambahkan 1
        $delivery_order = DeliveryOrder::whereYear('tanggal_pengiriman', date('Y'))
                                ->whereMonth('tanggal_pengiriman', date('m'))
                                ->latest()->first();

        if ($delivery_order == null) {
            $delivery_order = 1;
        }else {
            $kode = substr($delivery_order->kode_delivery_order,11);
            // dd($kode);
            $delivery_order = (int)$kode + 1;
        }

        // Angka kode delivery_order selanjutnya ditambahkan ke kode delivery_order
        // Format kode delivery_order yaitu DO-{TAHUN}/{angka}
        $data['kode_delivery_order'] = "DO-" . date('Y/m/') . $delivery_order;

        // mengambil data detail barang yang akan dijual
        $data['delivery_order_detail'] = DeliveryOrderDetails::where('kode_delivery_order', $data['kode_delivery_order'])->get();
        $data['barang'] = Barang::get();
        return view('admin.delivery-order.create', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_delivery_order' => 'required',
            'barang_id' => 'required'
        ]);

        $barang = Barang::where('id', $validated['barang_id'])->first();

        $data['kode_delivery_order'] = $validated['kode_delivery_order'];
        $data['kode_barang'] = $barang->kode;
        $data['nama_barang'] = $barang->nama;
        $data['jumlah'] = 1;
        $data['satuan'] = $barang->satuan;
        $data['total'] = $barang->harga_jual;

        // cek detail delivery order
        $cek = DeliveryOrderDetails::where([
            ['kode_delivery_order', $validated['kode_delivery_order']],
            ['kode_barang', $data['kode_barang']]
        ])->first();

        if ($cek) {
            $cek->update([
                'jumlah' => 1
            ]);
        } else {
            DeliveryOrderDetails::create($data);
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

    public function storeDeliveryOrder(Request $request)
    {
        $validated = $request->validate([
            'kode_invoice' => 'required',
            'kode_delivery_order' => 'required',
            'nama_customer' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'tanggal_pengiriman' => 'required',
        ]);

        DeliveryOrder::create($validated);

        Alert::success('', 'Delivery Order Berhasil Dibuat!');

        return redirect('delivery-order');
    }

    public function showPdf(DeliveryOrder $delivery_order)
    {
        $data['delivery_order'] = $delivery_order->load(['details']);
        $pdf = Pdf::loadView('admin.delivery-order.pdf', $data);
        return $pdf->stream('delivery-order.pdf');
    }

    public function delete($id)
    {
        $delete=DeliveryOrderDetails::where('id',$id)->delete();
        if($delete)
        {
            Alert::success('','data berhasil dihapus');
        }else{
            Alert::error('','data gagal dihapus');
        }
        return redirect()->route('deliveryorder.create');
    }
}
