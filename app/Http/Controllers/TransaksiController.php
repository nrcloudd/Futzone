<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Http\Resources\LapanganResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LapanganController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $transaksis = Lapangan::latest()->paginate(5);

        //return collection of posts as a resource
        return new LapanganResource(true, 'List Data Posts', $transaksis);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'id_member' => 'required',
            'id_lapagan' => 'required',
            'jam' => 'required',
            'tanggal' => 'required',
            'total_bayar' => 'required',
            'bukti_bayar' => 'required',
            //'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        //$image = $request->file('image');
        //$image->storeAs('public/posts', $image->hashName());

        //create post
        $transaksi = Transaksi::create([
            'id_member' => $request->id_member,
            'id_lapangan' => $request->id_lapangan,
            'jam' => $request->jam,
            'tanggal' => $request->tanggal,
            'total_bayar' => $request->total_bayar,
            'bukti_bayar' => $request->bukti_bayar,

            //'image'     => $image->hashName(),
        ]);

        //return response
        return new LapanganResource(true, 'Data Post Berhasil Ditambahkan!', $transaksi);
    }

    /**
     * show
     *
     * @param  mixed $transakasi
     * @return void
     */
    public function show()
    {
        $transaksi = Lapangan::all();
        //return single post as a resource
        return new LapanganResource(true, 'Data Post Ditemukan!', $transaksi);
    }
}