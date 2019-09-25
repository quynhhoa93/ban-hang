<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product= Product::where('status',1)->get();
        return view('admin.pages.product.list',compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::where('status',1)->get();
        $producttype = ProductType::where('status',1)->get();
        return view('admin.pages.product.add',compact('category','producttype'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('image')){
            $file= $request->image;
            //lay ten file
            $file_name = $file->getClientOriginalName();
            //lay loai file
            $file_type = $file->getMimeType();
            //lay kich thuoc file theo byte
            $file_size = $file->getSize();
            if($file_type =='image/png'||$file_type == 'image/jpg'||$file_type=='image/jpeg'||$file_type=='image/gif'){
                if($file_size<=1048576){
                    $file_name = date('D-m-yyyy').'_'.utf8tourl($file_name);
                    if($file->move('img/upload/product',$file_name)){
                        $data = $request->all();
                        $data['slug'] =utf8tourl($request->name);
                        $data['image']=$file_name;
                        Product::create($data);
                        return redirect()->route('product.index')->with('thongbao','Đã thêm thành công sản phẩm');
                    }
                }else{
                    return back()->with('error','file ảnh không được quá 1 mb');
                }
            }else{
                return back()->with('error','Đây không phải là file ảnh');
            }
        }else{
            return back()->with('error','Chưa có ảnh cho sản phẩm này');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
