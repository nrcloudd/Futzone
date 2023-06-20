<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $employees = Employee::latest()->paginate(5);
        return view('employee.index', compact('employees'));
        //return collection of posts as a resource
        //return new EmployeeResource(true, 'List Data Posts', $employees);
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
            'namaEmploy' => 'required',
            'emailEmploy' => 'required',
            'passEmploy' => 'required',
            'level' => 'required',
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
        $employee = Employee::create([
            'namaEmploy' => $request->namaEmploy,
            'emailEmploy' => $request->emailEmploy,
            'passEmploy' => $request->passEmploy,
            'level' => $request->level,
            //'image'     => $image->hashName(),
        ]);

        //return response
        return new EmployeeResource(true, 'Data Post Berhasil Ditambahkan!', $employee);
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
        return new EmployeeResource(true, 'Data Post Ditemukan!', $employee);
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
        $employee = Employee::findOrFail($id);

        if ($request->has('namaEmploy')) {
            $employee->namaEmploy = $request->input('namaEmploy');
        }

        if ($request->has('emailEmploy')) {
            $employee->emailEmploy = $request->input('emailEmploy');
        }

        if ($request->has('passEmploy')) {
            $employee->passEmploy = $request->input('passEmploy');
        }

        if ($request->has('level')) {
            $employee->level = $request->input('level');
        }

        $employee->save();

        return response()->json($employee);
    }
    /**
     * destroy
     *
     * @param  mixed $employee
     * @return void
     */
    public function destroy(Employee $employee)
    {
        //delete image
        //Storage::delete('public/posts/' . $lapangan->image);

        //delete post
        $employee->delete();

        //return response
        return new EmployeeResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}