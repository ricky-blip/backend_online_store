<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::all();

        return view('product.index', compact('data'));
    }

    public function add()
    {
        // ambil data dari tabel merk utk ditampilkan di form tambah product
        $merk = Merk::orderBy('merk_product', 'ASC')->get();

        return view('product.add', compact('merk'));
    }

    public function store(Request $request)
    {
        // validasi data
        $request->validate([
            'merk_id' => 'required',
            'nama_product' => 'required|min:5|unique:products',
            'harga' => 'required',
            'rekomendasi' => 'required',
            'gambar' => 'required|image|file|max:2048', // 1mb = 1024kb, 2mb = 2048kb
        ], [
            'merk_id.required' => 'Merk harus diisi!',
            'nama_product.required' => 'Nama Produk harus diisi!'
        ]);

        // dd($request->all());
        try {
            //tentukan folder penyimpanan gambarnya
            $pathGambar = $request->file('gambar')->store('product-images');

            // insert data ke tabel products
            Product::create([
                'merk_id' => $request->merk_id,
                'nama_product' => $request->nama_product,
                'harga' => $request->harga,
                'gambar' => $pathGambar,
                'spesifikasi' => $request->spesifikasi,
                'status' => $request->status,
                'rekomendasi' => $request->rekomendasi,
            ]);

            return redirect('product');
        } catch (Exception $error) {
            return redirect()
                ->back()
                ->with([
                    'failed' => $error->getMessage(),
                ]);
        }
    }

    public function edit($id)
    {
        // ambil data dari tabel merk
        $merk = Merk::orderBy('merk_product', 'ASC')->get();

        // ambil data product berdasarkan id yg dipilih
        $data = Product::find($id);
        return view('product.edit', compact('merk', 'data'));
    }

    public function update(Request $request)
    {
        try {
            // ambil data produk yg dipilih berdasarkan id
            $product = Product::find($request->id);

            // cek apakah user mengupload gambar atau tidak
            if ($request->file('gambar')) {
                // cek apakah field gambar pd tabel products ada isinya atau tidak
                // kalau ada
                if ($product->gambar) {
                    // delete terlebih dahulu gambar lama
                    Storage::delete($product->gambar);
                }

                // upload file yg baru
                $pathGambar = $request->file('gambar')->store('product-images');

                // proses update data products dengan gambar
                Product::where('id', $request->id)->update([
                    'merk_id' => $request->merk_id,
                    'nama_product' => $request->nama_product,
                    'harga' => $request->harga,
                    'gambar' => $pathGambar,
                    'spesifikasi' => $request->spesifikasi,
                    'status' => $request->status,
                    'rekomendasi' => $request->rekomendasi,
                ]);
            } else {
                // proses update data products tanpa gambar
                Product::where('id', $request->id)->update([
                    'merk_id' => $request->merk_id,
                    'nama_product' => $request->nama_product,
                    'harga' => $request->harga,
                    'spesifikasi' => $request->spesifikasi,
                    'status' => $request->status,
                    'rekomendasi' => $request->rekomendasi,
                ]);
            }

            return redirect('product');
        } catch (Exception $error) {
            return redirect()
                ->back()
                ->with([
                    'failed' => $error->getMessage(),
                ]);
        }
    }

    public function delete($id)
    {
        try {
            // ambil data produk yg dipilih berdasarkan id
            $product = Product::find($id);

            if ($product->gambar) {
                // hapus dulu file gambarnya
                Storage::delete($product->gambar);
            }

            // hapus data product yg dipilih
            Product::destroy($id);

            return redirect('product');
        } catch (Exception $error) {
            return redirect()
                ->back()
                ->with([
                    'failed' => $error->getMessage(),
                ]);
        }
    }
}
