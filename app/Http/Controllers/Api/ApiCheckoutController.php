<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Keranjang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApiCheckoutController extends Controller
{

    public function postCheckout(Request $request)
    {
        // ambil total harga yg ada di tabel keranjangs yg statusnya adalah 0 = keranjang, 1 = checkout 
        $getTotalHarga = DB::table('keranjangs')
            ->select(DB::raw('SUM(totalharga) as totalharga '))
            ->where('status', '0')
            ->where('user_id', $request->user_id)
            ->first();
        // var_dump($getTotalHarga->totalharga);
        // die;
        if ($getTotalHarga->totalharga == NULL) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Keranjang Kosong!',
                    'data' => []
                ],
                500
            );
            die;
        }

        $ongkir = 25000;

        // Db transaction => akan mengupdate data apabila proses 1 berhasil dilakukan
        // jika proses pertama/kedua saat di proses ketiga gagal, maka proses 1 dan 2 dibatalkan
        // proses yg akan dilakukan : 1. update data yg ada di tabel detailpemesanas (checkout_id)
        // 2. insert data baru ke tabel checkouts

        // opening db transaction
        DB::beginTransaction();

        try {
            // isi proses
            // 1. proses insert data ke tabel checkouts
            $postCheckout = Checkout::create([
                'kode_transaksi' => 'STP-' . Str::random(5),
                'user_id' => $request->user_id,
                'nama' => $request->nama,
                'nohp' => $request->nohp,
                'alamat' => $request->alamat,
                'kota_kecamatan' => $request->kota_kecamatan,
                'catatan' => $request->catatan,
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'jenis_pengiriman' => $request->jenis_pengiriman,
                'ongkir' => $ongkir,
                'grand_total' => $getTotalHarga->totalharga + $ongkir
            ]);

            // 2. proses update checkout_id di tabel keranjangs
            // ambil dulu id pada tabel checkouts yg barusan disimpan ke database
            $checkout_id = $postCheckout->id;

            // proses update tabel keranjangs pd field checkout_id dan status

            // yg bakal diupdate adlh yg statusnya masih keranjang (0)
            $updateDetail = Keranjang::where('status', '0')->where('user_id', $request->user_id)->update([
                'checkout_id' => $checkout_id,
                'status' => '1'
            ]);

            // success transaction
            DB::commit();

            // response success
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Post Data Berhasil',
                    'data' => $postCheckout
                ],
                200
            );
        } catch (Exception $error) {

            // saat gagal, maka cancel smua transaction data
            DB::rollBack();

            // response gagal
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Post Data Gagal ' . $error->getMessage(),
                    'data' => []
                ],
                500
            );
        }
    }

    public function getCheckoutBaru()
    {
        $datas = [];
        $items = [];
        try {
            $data = Checkout::where('user_id', request('user_id'))->where('status', '0')->get();
            // response success
            
            foreach($data as $dt) {
                $item = DB::table('keranjangs')
                        ->join('products', 'products.id','keranjangs.product_id')
                        ->join('merks', 'merks.id', 'products.merk_id' )
                        ->select(DB::raw(
                            'keranjangs.*, products.nama_product, products.gambar, products.harga as harga_satuan, merks.merk_product'
                        ))
                        ->where('keranjangs.checkout_id',$dt->id)
                        ->first();
                
                // foreach($items as $itm) {
                //     $items[] = $itm;
                // }
                
                $datas[] = [
                    'id' => $dt->id,
                    'kode_transaksi' => $dt->kode_transaksi,
                    'user_id' => $dt->user_id,
                    'nama' => $dt->nama,
                    'nohp' => $dt->nohp,
                    'kota_kecamatan' => $dt->kota_kecamatan,
                    'alamat' => $dt->alamat,
                    'catatan' => $dt->catatan,
                    'jenis_pembayaran' => $dt->jenis_pembayaran,
                    'jenis_pengiriman' => $dt->jenis_pengiriman,
                    'ongkir' => $dt->ongkir,
                    'grand_total' => $dt->grand_total,
                    'buktibayar' => $dt->buktibayar,
                    'status' => $dt->status,
                    'created_at' => $dt->created_at,
                    'updated_at' => $dt->updated_at,
                    'item' => $item
                ];
            }
            
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Get Data Berhasil',
                    'data' => $datas
                ],
                200
            );
        } catch (Exception $error) {
            // response gagal
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Get Data Gagal ' . $error->getMessage(),
                    'data' => []
                ],
                500
            );
        }
    }

    public function getCheckoutProses()
    {
        $datas = [];

        try {
            $data = Checkout::where('user_id', request('user_id'))->where('status', '1')->get();
            
            foreach($data as $dt) {
                $item = DB::table('keranjangs')
                        ->join('products', 'products.id','keranjangs.product_id')
                        ->join('merks', 'merks.id', 'products.merk_id' )
                        ->select(DB::raw(
                            'keranjangs.*, products.nama_product, products.gambar, products.harga as harga_satuan, merks.merk_product'
                        ))
                        ->where('keranjangs.checkout_id',$dt->id)
                        ->first();
                
                // foreach($items as $itm) {
                //     $items[] = $itm;
                // }
                
                $datas[] = [
                    'id' => $dt->id,
                    'kode_transaksi' => $dt->kode_transaksi,
                    'user_id' => $dt->user_id,
                    'nama' => $dt->nama,
                    'nohp' => $dt->nohp,
                    'kota_kecamatan' => $dt->kota_kecamatan,
                    'alamat' => $dt->alamat,
                    'catatan' => $dt->catatan,
                    'jenis_pembayaran' => $dt->jenis_pembayaran,
                    'jenis_pengiriman' => $dt->jenis_pengiriman,
                    'ongkir' => $dt->ongkir,
                    'grand_total' => $dt->grand_total,
                    'buktibayar' => $dt->buktibayar,
                    'status' => $dt->status,
                    'created_at' => $dt->created_at,
                    'updated_at' => $dt->updated_at,
                    'item' => $item
                ];
            }

            // response success
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Get Data Berhasil',
                    'data' => $datas
                ],
                200
            );
        } catch (Exception $error) {
            // response gagal
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Get Data Gagal ' . $error->getMessage(),
                    'data' => []
                ],
                500
            );
        }
    }

    public function getCheckoutSelesai()
    {
        $datas = [];

        try {
            $data = Checkout::where('user_id', request('user_id'))->where('status', '2')->get();

            foreach($data as $dt) {
                $item = DB::table('keranjangs')
                        ->join('products', 'products.id','keranjangs.product_id')
                        ->join('merks', 'merks.id', 'products.merk_id' )
                        ->select(DB::raw(
                            'keranjangs.*, products.nama_product, products.gambar, products.harga as harga_satuan, merks.merk_product'
                        ))
                        ->where('keranjangs.checkout_id',$dt->id)
                        ->first();
                
                // foreach($items as $itm) {
                //     $items[] = $itm;
                // }
                
                $datas[] = [
                    'id' => $dt->id,
                    'kode_transaksi' => $dt->kode_transaksi,
                    'user_id' => $dt->user_id,
                    'nama' => $dt->nama,
                    'nohp' => $dt->nohp,
                    'kota_kecamatan' => $dt->kota_kecamatan,
                    'alamat' => $dt->alamat,
                    'catatan' => $dt->catatan,
                    'jenis_pembayaran' => $dt->jenis_pembayaran,
                    'jenis_pengiriman' => $dt->jenis_pengiriman,
                    'ongkir' => $dt->ongkir,
                    'grand_total' => $dt->grand_total,
                    'buktibayar' => $dt->buktibayar,
                    'status' => $dt->status,
                    'created_at' => $dt->created_at,
                    'updated_at' => $dt->updated_at,
                    'item' => $item
                ];
            }
            // response success
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Get Data Berhasil',
                    'data' => $datas
                ],
                200
            );
        } catch (Exception $error) {
            // response gagal
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Get Data Gagal ' . $error->getMessage(),
                    'data' => []
                ],
                500
            );
        }
    }

    public function getCheckoutDetail()
    {
        try {
            $detail = Checkout::where('user_id', request('user_id'))->where('id', request('id_pemesanan'))->first();
            $products = DB::table('keranjangs')
                ->join('products', 'products.id', 'keranjangs.product_id')
                ->join('merks', 'merks.id', 'products.merk_id')
                ->select(DB::raw(
                    'keranjangs.*, products.nama_product, products.gambar, products.harga as harga_satuan, merks.merk_product'
                ))
                ->where('keranjangs.checkout_id', request('id_pemesanan'))
                ->get();

            // response success
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Get Data Berhasil',
                    'detail' => $detail,
                    'data' => $products
                ],
                200
            );
        } catch (Exception $error) {
            // response gagal
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Get Data Gagal ' . $error->getMessage(),
                    'detail' => $detail,
                    'data' => $products
                ],
                500
            );
        }
    }

    public function uploadBuktiBayar(Request $request){
        try {

            $checkout_id = $request->checkout_id;

            // cek data
            $data = Checkout::find($checkout_id);

            if($data->buktibayar != null) {
                Storage::delete($data->buktibayar);
                $pathGambar = $request->file('buktibayar')->store('bukti-bayar');
            } else {
                $pathGambar = $request->file('buktibayar')->store('bukti-bayar');
            }

            Checkout::where('id', $checkout_id)->update([
                'buktibayar' => $pathGambar,
            ]);
            // response success
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Upload Data Berhasil',
                    'data' => []
                ],
                200
            );
        } catch (Exception $error) {
            // response gagal
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Get Data Gagal ' . $error->getMessage(),
                    'data' => []
                ],
                500
            );
        }
    }

}
