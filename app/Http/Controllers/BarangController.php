<?php

namespace App\Http\Controllers;

use App\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $data['barang'] = Barang::get();

        // memuat kode barang otomatis
        $lastCode = Barang::orderBy('id', 'desc')->value('kode');

        if (!$lastCode) {
            $data['kode_barang'] = 'IMEL-001';
        }

        $lastNumber = (int) substr($lastCode, -3);
        $newNumber = $lastNumber + 1;
        $formattedNumber = str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        $data['kode_barang'] = 'IMEL-' . $formattedNumber;
        return view('admin.barang.index',$data);
    }

    public function store(Request $request)
    { 
        $validated = $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'harga_modal' => 'required',
            'harga_jual' => 'required',
            'stok' => 'required',
            'satuan' => 'required'
        ]);
       
        Barang::create($validated);

        return back();
    }
}
