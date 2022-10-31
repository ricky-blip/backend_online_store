<?php

namespace App\Http\Controllers;

use App\Mail\NotifEmail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index(){

        $details = [
            'title' => 'Notifikasi!',
            'body' => 'Ada Pesanan baru nih! Cek Admin yaasdfsfd!'
        ];
       try {
        Mail::to('wahidalqorni@gmail.com')->send(new NotifEmail($details));
       
        dd("Email sudah terkirim.");

       } catch (Exception $th) {
        dd($th->getMessage());
       }
        
    
        }
}
