<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductTypeRequest;
use App\Models\ProductType;
use App\Models\Category;
use Validator;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $producttype = ProductType::paginate(5);
        return view('admin.pages.producttype.list',compact('producttype'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::where('status',1)->get();
        return view('admin.pages.producttype.add',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductTypeRequest $request)
    {
        $data=$request->all();
        $data['slug']=utf8tourl($request->name);
//        dd($data);
        if(ProductType::create($data)){
            return redirect()->route('producttype.index')->with('thongbao','đã thêm thành công');
        }else{
            return back()->with('thongbao','có lỗi sảy ra xin kiểm tra lại');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producttype = ProductType::find($id);
        $category = Category::where('status',1)->get();
        return response()->json(['category'=>$category,'producttype'=>$producttype],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|min:2|max:255'
        ],[
            'required' => 'Tên loại sản phẩm không được bỏ trống',
            'min' => 'Tên loại sản phẩm tối thiểu có 2 ký tự',
            'max' => 'Tên loại sản phẩm tối đa có 255 ký tự',
        ]);
        if($validator->fails()){
            return response()->json(['error'=>'true','message'=>$validator->errors()],200);
        }
        $producttype = ProductType::find($id);
        $data = $request->all();
        $data['slug']=utf8tourl($request->name);
        if($producttype->update($data)){
            return response()->json(['result'=>'đã sửa thành công loại sản phẩm có id'.$id],200);
        }else{
            return response()->json(['result'=>'đã không sửa thành công loại sản phẩm có id '.$id],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producttype = ProductType::find($id);
        if($producttype->delete()){
            return response()->json(['result'=>'đã xoá thành công loại sản phẩm có id'.$id],200);
        }else{
            return response()->json(['result'=>'đã không xoá thành công loại sản phẩm có id'.$id],200);

        }
    }
}
