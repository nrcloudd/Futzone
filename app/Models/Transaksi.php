<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'namaMember',
        'namaLapangan',
        'jamAwal',
        'jamAkhir',
        'tanggal',
        'total_bayar',
        'sisa_bayar',
        'bukti_bayar'
        //'image',

    ];
}
