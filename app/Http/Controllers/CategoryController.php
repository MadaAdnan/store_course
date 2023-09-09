<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
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
        return response()->json([
            'categories'=>CategoryResource::collection(Category::all()),
            'status'=>'success',
        ]);

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
            return response()->json([
                'msg'=>$val->getMessageBag()->first(),
                'status'=>'error',
            ],401);

        }
       $category= Category::create([
            'user_id'=>$request->user_id,
            'name'=>$request->name,
        ]);
        if($category){
            return response()->json([
                'category'=> new CategoryResource($category),
                'status'=>'success',
            ]);
        }

        return response()->json([
            'msg'=>'لم يتم الإضافة يرجى المحاولة مجددا',
            'status'=>'error',
        ],401);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new CategoryResource(Category::find($id));
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
