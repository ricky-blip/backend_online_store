<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // menampilkan data user dari database
        $data = User::all();
        // dd($data);
        return view('user.index', compact('data') );
    }

    public function add()
    {
        // menampilkan form add.blade.php
        return view('user.add');
    }

    public function store(Request $request)
    {
        
        try {
            //fungsi insert data
            User::create([
                'name' => $request->name, // ambil nilai dari inputan yg ada di form sesuai dengan atribut namenya
                'email' => $request->email, // ambil nilai dari inputan yg ada di form sesuai dengan atribut namenya
                'password' => Hash::make($request->password), // ambil nilai dari inputan yg ada di form sesuai dengan atribut namenya
                'role' => $request->role // ambil nilai dari inputan yg ada di form sesuai dengan atribut namenya
            ]);

            return redirect('user');

        } catch (Exception $error) {
            //jika terjadi error
            return redirect()->back()->with([
                'failed' => $error->getMessage() // ambil pesan error yg di catch
            ]);
        }
    }

    public function edit($id)
    {
        $data = User::find($id);

        return view('user.edit', compact('data') );
    }

    public function update(Request $request)
    {
        
        try {
            // ambil data user berdasarkan idnya
            $id = $request->id;
            $user = User::find($id);

            // jika password tidak kosong, maka update field passwordnya
            if($request->password) {
                $newPassword = Hash::make($request->password);
            } else {
                // jika password kosong, maka passwordny tetap password lama yg ada di databse
                // sesuai dengan data password user yg dipilih
                $newPassword = $user->password;
            }

            //fungsi update data
            User::where('id', $id )->update([
                'name' => $request->name, // ambil nilai dari inputan yg ada di form sesuai dengan atribut namenya
                'password' => $newPassword, 
                'role' => $request->role // ambil nilai dari inputan yg ada di form sesuai dengan atribut namenya
            ]);

            return redirect('user');

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
            User::destroy($id);
            return redirect('user');
        } catch (Exception $error) {
            //jika terjadi error
            return redirect()->back()->with([
                'failed' => $error->getMessage() // ambil pesan error yg di catch
            ]);
        }
    }

}
