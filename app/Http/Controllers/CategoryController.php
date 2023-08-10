<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $val=Validator::make($request->all(),[
            'user_id'=>'required|exists:users,id',
            'name'=>'required',
        ],[
            'user_id.required'=>'يرجى تحديد المستخدم',
            'user_id.exists'=>'يرجى تحديد متجر',
        ]);
        if($val->fails()){
            return  $val->getMessageBag();
        }
        Category::create([
            'user_id'=>$request->user_id,
            'name'=>$request->name,
        ]);
        return 'success';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Category::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Category::find($id)->update([
            'name'=>$request->name,
        ]);
        return "success";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::find($id)->delete();
    }
}
