<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = User::findOrFail($request->input('id'));

        if ($request->has('name')) {
            $user->name = $request->input('name');
        }

        if ($request->has('email')) {
            $user->email = $request->input('email');
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->has('phone')) {
            $user->phone = $request->input('phone');
        }

        $user->save();


        return response()->json($user);
    }
}
