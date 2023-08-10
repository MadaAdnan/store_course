<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),//Hash::make($request->password),
            'level' => 'user',
            'status' => 'pending',
        ]);
        return "success";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,

        ];
        if ($request->password != null) {
            $data['password'] = bcrypt($request->password);
        }
        User::find($id)->update($data);
        return "success";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();
        return "success";
    }
}
