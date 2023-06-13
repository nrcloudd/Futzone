<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShowUserController extends Controller
{
    public function show()
    {
        $user = User::all();
        //return single post as a resource
        return new UserResource(true, 'Data Post Ditemukan!', $user);
    }

}
