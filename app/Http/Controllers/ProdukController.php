<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    //
    public function index()
    {
        $var_produk =['Nama'=>'kopi', 'Harga'=>'Rp. 10.000',];
        return view('produk', compact('var_produk'));
    }
}
