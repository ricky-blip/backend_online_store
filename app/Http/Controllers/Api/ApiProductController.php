<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Merk;
use App\Models\Product;
use Illuminate\Http\Request;

class ApiProductController extends Controller
{
    // menampilkan merk
    public function getMerk()
    {
        $data = Merk::orderBy('merk_product')->get();

        // tampilkan responsenya
        // menggunakan format json
        return response()->json(
            [
                'success' => true,
                'message' => 'Data berhasil diload',
                'data' => $data,
            ],
            200
        );
    }

    // menampilkan product berdasarkan merk_id
    public function getProductByMerkId()
    {
        $data = Product::with(['merk'])
            ->where('status', '1')
            ->where('merk_id', request('merk_id') )
            ->orderBy('nama_product', 'ASC')
            ->get();

        // tampilkan responsenya
        // menggunakan format json
        return response()->json(
            [
                'success' => true,
                'message' => 'Data berhasil diload',
                'data' => $data,
            ],
            200
        );
    }

    // menampilkan product rekmoendasi
    public function getRekomendasi()
    {
        $data = Product::with(['merk'])
            ->where('status', '1')
            ->where('rekomendasi', '1')
            ->limit(4)
            ->orderBy('nama_product', 'ASC')
            ->get();

        // tampilkan responsenya
        // menggunakan format json
        return response()->json(
            [
                'success' => true,
                'message' => 'Data berhasil diload',
                'data' => $data,
            ],
            200
        );
    }

    public function getAllProduct()
    {
        $data = Product::with(['merk'])
            ->where('status', '1')
            ->orderBy('nama_product', 'ASC')
            ->get();

        // tampilkan responsenya
        // menggunakan format json
        return response()->json(
            [
                'success' => true,
                'message' => 'Data berhasil diload',
                'data' => $data,
            ],
            200
        );
    }

    public function getNewProduct()
    {
        $data = Product::with(['merk'])
            ->where('status', '1')
            ->orderBy('created_at', 'DESC')
            ->limit(3)
            ->get();

        // tampilkan responsenya
        // menggunakan format json
        return response()->json(
            [
                'success' => true,
                'message' => 'Data berhasil diload',
                'data' => $data,
            ],
            200
        );
    }

    public function detailProduct($id)
    {
        $data = Product::with(['merk'])
            ->where('id', $id)
            ->first();
        
        if($data) {
            // tampilkan responsenya
            // menggunakan format json
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data berhasil diload',
                    'data' => $data,
                ],
                200
            );
        } else {
            // tampilkan responsenya
            // menggunakan format json
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Data ditemukan',
                    'data' => $data,
                ],
                404
            );
        }
    }

    public function searchProduct(Request $request)
    {
        $keyword = $request->keyword;

        $data = Product::with(['merk'])
            ->where('status', '1') // seleksi tabel products yg statusny = '1' atau publish
            ->where('nama_product', 'like', '%' . $keyword . '%')
            ->orWhereRelation(
                'merk', // fungsi yg direlasikan (belongsTo) -> cek di App\Models\Product
                'merk_product', // ambil field yg ingin di seleksi
                'like',
                '%' . $keyword . '%'
            )
            ->orderBy('nama_product', 'ASC')
            ->get();

        // tampilkan responsenya
        // menggunakan format json
        return response()->json(
            [
                'success' => true,
                'message' => 'Data berhasil diload',
                'data' => $data,
            ],
            200
        );
    }
}
