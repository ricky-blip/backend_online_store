<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Keranjang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        // data dari tabel checkouts yg akan ditampilkan
        $data = Checkout::all();

        // return view yg akan menampilkan datanya
        return view('checkout.index', compact('data') );

    }

    public function detail($id)
    {
        // data dari tabel checkouts yg akan ditampilkan
        // SELECT * FROM checkouts WHERE id = $id
        $data = Checkout::find($id);

        // tampilkan product2x yang ada di detail pemesanan (dari tabel keranjangs yg checkout_id.nya sama dengan id yg ada di tabel checkouts). id checkoutny di kirim saat menekan tombol Detail di view pemesanan (checkout/index.blade.php)
        $products = DB::table('keranjangs')
        ->join('products', 'products.id','keranjangs.product_id')
        ->join('merks', 'merks.id', 'products.merk_id' )
        ->select(DB::raw(
            'keranjangs.*, products.nama_product, products.gambar, products.harga as harga_satuan, merks.merk_product'
        ))
        ->where('keranjangs.checkout_id',$id)
        ->get();
        
        // return view yg akan menampilkan detail pemesanan
        return view('checkout.detail', compact('data','products') );
    }

    public function updateStatus(Request $request) // Request => menerima inputan dari form
    {
        try {
            // ambil data checkouts berdasarkan idnya
            $id = $request->id; // $request->id ini sesuai dengan name yg ada di form inputan
        
            //fungsi update data
            Checkout::where('id', $id )->update([
                'status' => $request->status // ambil nilai dari inputan yg ada di form sesuai dengan atribut merk_productnya
            ]);

            return redirect()->back()->with([
                'success' => "Data berhasil diupdate!"
            ]);

        } catch (Exception $error) {
            //jika terjadi error
            return redirect()->back()->with([
                'failed' => $error->getMessage() // ambil pesan error yg di catch
            ]);
        }
    }

}
