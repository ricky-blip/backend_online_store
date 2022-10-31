<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // menghubungkan tabel products dengan tabel merks
    public function merk()
    {
        return $this->belongsTo(Merk::class, 'merk_id','id');
    }

    // menampilkan data gambar beserta link akses filenya
    public function getGambarAttribute($value)
    {
        return url(Storage::url($value));
    }
}
