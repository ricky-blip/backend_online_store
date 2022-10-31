<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use Exception;
use Illuminate\Http\Request;

class MerkController extends Controller
{
    public function index()
    {
        // menampilkan data merk dari database
        $data = Merk::orderBy('merk_product','ASC')->get();
        // dd($data);
        return view('merk.index', compact('data') );
    }

    public function add()
    {
        // menampilkan form add.blade.php
        return view('merk.add');
    }

    public function store(Request $request)
    {
        
        try {
            //fungsi insert data
            Merk::create([
                'merk_product' => $request->merk_product, // ambil nilai dari inputan yg ada di form sesuai dengan atribut merk_productnya
                'status' => $request->status // ambil nilai dari inputan yg ada di form sesuai dengan atribut merk_productnya
            ]);

            return redirect('merk');

        } catch (Exception $error) {
            //jika terjadi error
            return redirect()->back()->with([
                'failed' => $error->getMessage() // ambil pesan error yg di catch
            ]);
        }
    }

    public function edit($id)
    {
        $data = Merk::find($id);

        return view('merk.edit', compact('data') );
    }

    public function update(Request $request)
    {
        
        try {
            // ambil data merk berdasarkan idnya
            $id = $request->id;
        
            //fungsi update data
            Merk::where('id', $id )->update([
                'merk_product' => $request->merk_product, // ambil nilai dari inputan yg ada di form sesuai dengan atribut merk_productnya 
                'status' => $request->status // ambil nilai dari inputan yg ada di form sesuai dengan atribut merk_productnya
            ]);

            return redirect('merk');

        } catch (Exception $error) {
            //jika terjadi error
            return redirect()->back()->with([
                'failed' => $error->getMessage() // ambil pesan error yg di catch
            ]);
        }
    }

    public function delete($id)
    {
        try {
            Merk::destroy($id);
            return redirect('merk');
        } catch (Exception $error) {
            //jika terjadi error
            return redirect()->back()->with([
                'failed' => $error->getMessage() // ambil pesan error yg di catch
            ]);
        }
    }
}
