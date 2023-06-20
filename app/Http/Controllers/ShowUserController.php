<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Resources\UserResource;

use Illuminate\Http\Request;

class ShowUserController extends Controller
{
    public function index()
    {
        //get posts
        $users = User::latest()->paginate(5);
        return view('member.index', compact('users'));

        //return collection of posts as a resource
        return new UserResource(true, 'List Data Posts', $users);
    }
    public function show()
    {
        $user = User::all();
        //return single post as a resource
        return new UserResource(true, 'Data Post Ditemukan!', $user);
    }

}
