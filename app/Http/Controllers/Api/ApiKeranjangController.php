<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiKeranjangController extends Controller
{
    public function getAllKeranjang()
    {
        $data = DB::table('keranjangs')
                ->join('products', 'products.id','keranjangs.product_id')
                ->join('merks', 'merks.id', 'products.merk_id' )
                ->select(DB::raw(
                    'keranjangs.*, products.nama_product, products.gambar, products.harga as harga_satuan, merks.merk_product'
                ))
                ->where('keranjangs.status','0')
                ->where('keranjangs.user_id',request('user_id'))
                ->get();

        if($data) {
            $jumlahBarang = $data->count();
        } else {
            $jumlahBarang = 0;
        }

        $grandTotal = DB::table('keranjangs')
                      ->select(DB::raw(
                          'SUM(totalharga) as grandtotal'
                      ))
                      ->where('status','0')
                      ->where('user_id',request('user_id'))
                      ->first();
                
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diload',
            'jumlahBarang' => $jumlahBarang,
            'grandtotal' => (int)$grandTotal->grandtotal,
            'data' => $data
        ], 200);
    }

    public function postKeranjang(Request $request)
    {
        try {
            //inputan dari client
            $product_id = $request->product_id;
            $jumlah = $request->jumlah;
            $user_id = $request->user_id;

            // ambil harga product di tabel products berdasarkan product_id yg diinputkan
            $product = Product::find($product_id);
            if(!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product tidak ditemukan!',
                    'data'    => []
                ], 404);
                die;
            }
            $hargaproduct = $product->harga;

            // pengecekan apakah produk sudah ada di tabel keranjang atau blum
            // pengecekan sesuai product_id yg diinputkan dan statusnya adalah '0'
            $cekKeranjang = Keranjang::where('product_id', $product_id)->where('status','0')->where('user_id',$request->user_id)->first();

            // jika produk ditemukan
            // maka lakukan update data
            if($cekKeranjang) {
                
                $post = Keranjang::where('product_id', $product_id)->where('status','0')->where('user_id',$request->user_id)
                ->update(
                    [
                        'jumlah' => $cekKeranjang->jumlah + $jumlah, // ambil nilai pd field jumlah dr tabel dan tambahkan dengan jumlah yg diinputkan
                        'totalharga' => ($cekKeranjang->jumlah + $jumlah ) * $hargaproduct // ambil nilai pd field jumlah dari tabel dan tambahkan dengan jumlah yg diinputkan serta kalikan dengan harga produk sesuai product_id yg dipilih
                    ]
                );
            } else {
                
                // mengirim data ke tabel keranjang
                $post = Keranjang::create([
                    'product_id' => $product_id,
                    'user_id' => $request->user_id,
                    'jumlah' => $jumlah,
                    'totalharga' => $hargaproduct * $jumlah
                ]);
            }
            
            //  return response()->json([
            //         'success' => true,
            //         'message' => 'Input keranjang berhasil!',
            //         'data'    => $post
            //     ], 200);
            
            
            if($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Input keranjang berhasil!',
                    'data'    => $post
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Input keranjang gagal!',
                    'data'    => $post
                ], 500);
            }

        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
                'data'    => []
            ], 500);
        }
    }

    public function deleteKeranjang(Request $request)
    {
        $id = $request->id;

        try {
            $delete = Keranjang::destroy($id);
            if($delete) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil dihapus!',
                    'data'    => []
                ], 200 );
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data gagal dihapus!',
                    'data'    => []
                ], 500 );
            }
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
                'data'    => []
            ], 500 );
        }
    }
    
}
