<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use File;
use App\Services\ImageService;
use Validator;


class ProductController extends Controller
{
    protected $image_service;
    public function __construct(ImageService $imageService){
        $this->image_service = $imageService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product= Product::paginate(5);
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
    public function store(StoreProductRequest $request)
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
    public function edit($id)
    {
        $category = Category::where('status',1)->get();
        $producttype = ProductType::where('status',1)->get();
        $product = Product::find($id);
        return response()->json(['category'=>$category,'producttype'=>$producttype,'product'=>$product],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|min:2|max:255',
                'description' => 'required|min:2',
                'quantity' => 'required|numeric',
                'price' => 'required|numeric',
                'promotional' => 'numeric',
                'image' => 'image',
            ],
            [
                'required' => ':attribute không được bỏ trống',
                'min' => ':attribute tối thiểu có 2 ký tự',
                'max' => ':attribute tối đa có 255 ký tự',
                'numeric' => ':attribute phải là một số ',
                'image' => ':attribute không là hình ảnh',
            ],
            [
                'name' => 'Tên sản phẩm',
                'description' => 'Mô tả sản phẩm',
                'quantity' => 'Số lượng sản phẩm',
                'price' => 'Đơn giá sản phẩm',
                'promotional' => 'Giá khuyến mại',
                'image' => 'Ảnh minh họa',
            ]
            );
        if($validator->fails()){
            return response()->json(['error'=>'true','message'=>$validator->errors()],200);
        }
        $product = Product::find($id);
        $data = $request->all();
        $data['slug'] = utf8tourl($request->name);
        if($request->hasFile('image')){
            $file = $request->image;
            if( $this->image_service->checkFile($file) == 1) {
                $nameImage = $this->image_service->moveImage($file, 'img/upload/product');
                if($nameImage != 0) {
                    $data['image'] = $nameImage;
                }
            } elseif ( $this->image_service->checkFile($file) == 0) {
                return response()->json(['result' => 'Ảnh của bạn quá lớn chỉ được upload ảnh dưới 1mb '.$id],200);
            }
        }else{
            $data['image'] = $product->image;
        }
        $product->update($data);
        return response()->json(['result' => 'Đã sửa thành công sản phẩm có id là '.$id],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $this->image_service->deleteFile($product->image, 'img/upload/product');
        $product->delete();
        return response()->json(['result'=>'Đã xoá thành công'],200);
    }
}
