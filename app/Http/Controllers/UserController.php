<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        return User::query()->create($request->all());
    }
}
