<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\TipeLapangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LapanganResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LapanganController extends Controller
{
    public function anjay(){
        $jointipe = Lapangan::join('tipe_lapangan', 'lapangans.tipeLapangan', '=', 'tipe_lapangan.id')//Im not sure about this 
            ->select('lapangans.*', 'tipe_lapangan.tipeLapangan as tipe', 'tipe_lapangan.harga as harga')  // neither this 
            ->get();

            return new LapanganResource(true, 'Data Post Ditemukan!', $jointipe);
    }
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $lapangans = Lapangan::latest()->paginate(5);
        return view('lapangan.index', compact('lapangans'));
       
        //return collection of posts as a resource
        //return new LapanganResource(true, 'List Data Posts', $lapangans);
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
            'namaLapangan' => 'required',
            'tipeLapangan' => 'required',
            'harga' => 'required',
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //$tipel = TipeLapangan::Find($request->input('tipeLapangan'));

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        //create post   
        $lapangan = Lapangan::create([
            'namaLapangan' => $request->namaLapangan,
            'tipeLapangan' => $request->tipeLapangan,
            'harga' => $request->harga,
            'image'     => $image->hashName(),
        ]);

        //return response
        return new LapanganResource(true, 'Data Post Berhasil Ditambahkan!', $lapangan);
    }

    /**
     * show
     *
     * @param  mixed $lapangan
     * @return void
     */
    public function show(Lapangan $lapangan)
    {
        $lapangan = Lapangan::all();
        //return single post as a resource
        return new LapanganResource(true, 'Data Post Ditemukan!', $lapangan);
    }

    public function show2(Request $request)
    {
        $id = $request->input('id');
    
        $jointipe = Lapangan::join('tipe_lapangan', 'lapangans.tipeLapangan', '=', 'tipe_lapangan.id')
            ->select('lapangans.*', 'tipe_lapangan.tipeLapangan as tipe', 'tipe_lapangan.harga as harga')
            ->where('lapangans.id', $id)
            ->get();
    
        if ($jointipe->isEmpty()) {
            return new LapanganResource(false, 'Data Post Tidak Ditemukan!', null);
        }
    
        $lapanganData = $jointipe[0];
        $tipeLapangan = $lapanganData['tipe'];
        $harga = $lapanganData['harga'];
    
        return new LapanganResource(true, 'Data Post Ditemukan!', [
            $lapanganData
        ]);
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
        $lapangan = Lapangan::findOrFail($id);

        if ($request->has('namaLapangan')) {
            $lapangan->namaLapangan = $request->input('namaLapangan');
        }

        if ($request->has('tipeLapangan')) {
            $lapangan->tipeLapangan = $request->input('tipeLapangan');
        }

        if ($request->has('harga')) {
            $lapangan->harga = $request->input('harga');
        }
        $lapangan->save();

        return response()->json($lapangan);
    }
    /**
     * destroy
     *
     * @param  mixed $lapangan
     * @return void
     */
    public function destroy(Lapangan $lapangan)
    {
        //delete image
        //Storage::delete('public/posts/' . $lapangan->image);

        //delete post
        $lapangan->delete();

        //return response
        return new LapanganResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}