<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransaksiResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $transaksis = Transaksi::latest()->paginate(5);
        return view('transaksi.index', compact('transaksis'));
        //return collection of posts as a resource
        //return new TransaksiResource(true, 'List Data Posts', $transaksis);
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
            'idMember' => 'required',
            'idLapagan' => 'required',
            'jam' => 'required',
            'tanggal' => 'required',
            'totalBayar' => 'required',
            'buktiBayar' => 'required',
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
            'idMember' => $request->idMember,
            'idLapangan' => $request->idLapangan,
            'jam' => $request->jam,
            'tanggal' => $request->tanggal,
            'totalBayar' => $request->totalBayar,
            'buktiBayar' => $request->buktiBayar,

            //'image'     => $image->hashName(),
        ]);

        //return response
        return new TransaksiResource(true, 'Data Post Berhasil Ditambahkan!', $transaksi);
    }

    /**
     * show
     *
     * @param  mixed $transakasi
     * @return void
     */
    public function show(Transaksi $transaksi)
    {
        $transaksi = Transaksi::all();
        //return single post as a resource
        return new TransaksiResource(true, 'Data Post Ditemukan!', $transaksi);
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $lapangan
     * @return void
     */
    // public function update(Request $request, $id)
    // {
    //     //define validation rules
    //     $validator = Validator::make($request->all(), [
    //         'namaLapangan' => 'required',
    //         'tipeLapangan' => 'required',
    //         'priceSiang' => 'required',
    //         'priceMalam' => 'required',
    //     ]);

    //     //check if validation fails
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //     //find post by ID
    //     $lapangan = Lapangan::find($id);

        //check if image is not empty
        //if ($request->hasFile('image')) {

            //upload image
            //$image = $request->file('image');
            //$image->storeAs('public/posts', $image->hashName());

            //delete old image
            //Storage::delete('public/posts/'.basename($post->image));

            //update post with new image
            //$post->update([
                //'image'     => $image->hashName(),
                //'title'     => $request->title,
                //'content'   => $request->content,
            //]);

        //} else {

            //update post without image
        //     $lapangan->update([
        //         'namaLapangan' => $request->namaLapangan,
        //     'tipeLapangan' => $request->tipeLapangan,
        //     'priceSiang' => $request->priceSiang,
        //     'priceMalam' => $request->priceMalam,
                
        //     ]);
        // }

        //return response
        //return new PostResource(true, 'Data Post Berhasil Diubah!', $post);
    //}

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($request->has('idMember')) {
            $transaksi->idMember = $request->input('idMember');
        }

        if ($request->has('idLapangan')) {
            $transaksi->idLapangan = $request->input('idLapangan');
        }

        if ($request->has('jam')) {
            $transaksi->jam = $request->input('jam');
        }

        if ($request->has('tanggal')) {
            $transaksi->tanggal = $request->input('tanggal');
        }
        if ($request->has('totalBayar')) {
            $transaksi->totalBayar = $request->input('totalBayar');
        }

        if ($request->has('buktiBayar')) {
            $transaksi->buktiBayar = $request->input('buktiBayar');
        }

        $transaksi->save();

        return response()->json($transaksi);
    }
    /**
     * destroy
     *
     * @param  mixed $lapangan
     * @return void
     */
    public function destroy(Transaksi $transaksi)
    {
        //delete image
        //Storage::delete('public/posts/' . $lapangan->image);

        //delete post
        $transaksi->delete();

        //return response
        return new TransaksiResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}