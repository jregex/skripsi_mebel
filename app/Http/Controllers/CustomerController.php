<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $data['customer'] = Customer::get();
        return view('admin.customer.index', $data);
    }

    public function store(Request $request)
    {
        
    }
}
