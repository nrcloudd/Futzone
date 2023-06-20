<?php

namespace App\Http\Controllers;

use App\Http\Resources\TipeLapangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TipeLapanganController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $tipe = \App\Models\TipeLapangan::latest()->paginate(5);
        //return collection of posts as a resource
        return new TipeLapangan(true, 'List Data Posts', $tipe);
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
            'tipeLapangan' => 'required',
            'harga' => 'required',
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
        $tipe = \App\Models\TipeLapangan::create([
            'tipeLapangan' => $request->tipeLapangan,
            'harga' => $request->harga,
            //'image'     => $image->hashName(),
        ]);

        //return response
        return new TipeLapangan(true, 'Data Post Berhasil Ditambahkan!', $tipe);
    }

    /**
     * show
     *
     * @param  mixed $lapangan
     * @return void
     */
    public function show(Employee $employee)
    {
        //return single post as a resource
        $tipe = \App\Models\TipeLapangan::all();
        return new EmployeeResource(true, 'Data Post Ditemukan!', $tipe);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $employee
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
        $tipe = TipeLapangan::findOrFail($id);

        if ($request->has('tipeLapangan')) {
            $tipe->tipeLapangan = $request->input('tipeLapangan');
        }

        if ($request->has('harga')) {
            $tipe->harga = $request->input('harga');
        }

        $tipe->save();

        return response()->json($tipe);
    }
    /**
     * destroy
     *
     * @param  mixed $employee
     * @return void
     */
    public function destroy(TipeLapangan $tipe)
    {
        //delete image
        //Storage::delete('public/posts/' . $lapangan->image);

        //delete post
        $tipe->delete();

        //return response
        return new EmployeeResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}