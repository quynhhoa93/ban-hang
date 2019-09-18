<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
//use Dotenv\Validator;
use Illuminate\Http\Request;
use Validator;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::paginate(5);
        return view('admin.pages.category.list',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.category.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->input('name');
        $category->slug = utf8tourl($request->input('name'));
        $category->status = $request->input('status');
        $category->save();
        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json($category,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $validator = Validator::make($request->all(),
        [
            'name'=>'required|min:2|max:255'
        ],
        [
            'required'=>'tên danh mục sản phẩm không được để trống',
            'min'=>'tên danh mục sản phẩm Phải có ít nhất 2 ký tự',
            'max'=>'tên danh mục sản phẩm Tối đa là 255 ký tự'
        ]
        );
        if($validator->fails()){
            return response()->json(['error'=>'true','message'=>$validator->errors()],200);
        }
        $category=Category::find($id);
        $category->update(
            [
                'name' => $request->name,
                'slug' => utf8tourl($request->name),
                'status' => $request->status
            ]
        );
        return response()->json(['success' => 'Sửa thành công']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json(['success'=>'xoá thành công']);
    }
}
