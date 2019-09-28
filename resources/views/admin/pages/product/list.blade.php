@extends('admin.layouts.master')

@section('title')
    Danh sách loại sản phẩm
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Loại Sản Phẩm</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Name</th>
                        <th>Mô tả</th>
                        <th>Thông tin</th>
                        <th>Danh mục sản phẩm</th>
                        <th>Loại sản phẩm</th>
                        <th>Status</th>
                        <th>Chỉnh sửa</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>Name</th>
                        <th>Mô tả</th>
                        <th>Thông tin</th>
                        <th>Danh mục sản phẩm</th>
                        <th>Loại sản phẩm</th>
                        <th>Status</th>
                        <th>Chỉnh sửa</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($product as $key => $value)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$value->name}}</td>
                            <td>{!! $value->description !!}</td>
                            <td>
                                <b>số lượng</b>: {{$value->quantity}}
                                <br>
                                <b>Đơn giá</b>: {{$value->price}}
                                <br>
                                <b>Khuyến mãi</b>: {{$value->promotional}}
                                <br>
                                <b>Hình minh hoạ</b>:
                                <img src="{{asset('img/upload/product')}}{{ '/'.$value->image }}" width="100" height="100">
                                {{--{{ asset("storage/uploads/$notes->file_name")}}--}}

                            </td>
                            <td>{{$value->categories->name}}</td>
                            <td>{{$value->productTypes->name}}</td>
                            <td>
                                @if($value->status==1)
                                    {{ "Hiển thị" }}
                                @else
                                    {{ "Không hiển thị" }}
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-primary editProduct" title="{{ "Sửa ".$value->name }}" data-toggle="modal" data-target="#edit" type="button" data-id="{{ $value->id }}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger deleteProduct" title="{{ "Xóa ".$value->name }}" data-toggle="modal" data-target="#delete" type="button" data-id="{{ $value->id }}"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{--<div class="pull-right">{{ $product->links() }}</div>--}}
            </div>
        </div>
    </div>
    <!-- Edit Modal-->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa category <span class="title"></span></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 5px">
                        <div class="col-lg-12">

                            <form role="form" id="updateProduct" method="post" enctype="multipart/form-data">

                                <fieldset class="form-group">
                                    <label>Tên sản phẩm</label>
                                    <input class="form-control name" name="name" placeholder="Nhập tên loại sản phẩm">
                                    <div class="alert alert-danger errorName" style="color: red;font-size: 1rem"></div>
                                </fieldset>

                                <div class="form-group">
                                    <label for="quantity">Số lượng</label>
                                    <input type="number" name="quantity" min="1" value="1" class="form-control quantity">
                                    <div class="alert alert-danger errorQuantity" style="color: red;font-size: 1rem"></div>
                                </div>

                                <div class="form-group">
                                    <label for="price">Đơn giá</label>
                                    <input type="number" name="price" placeholder="Nhập đơn giá" class="form-control price">
                                    <div class="alert alert-danger errorPrice" style="color: red;font-size: 1rem"></div>
                                </div>

                                <div class="form-group">
                                    <label for="promotional">Giá khuyến mãi</label>
                                    <input type="number" name="promotional" placeholder="Nhập giá khuyến mãi nếu có" class="form-control promotional">
                                    <div class="alert alert-danger errorPromotional" style="color: red;font-size: 1rem"></div>
                                </div>

                                <img src="" class="img-thumbnail img imageThum" width="100" height="100" align="center">
                                <div class="form-group">
                                    <label for="image">Ảnh sản phẩm</label>
                                    <input type="file" name="image" class="form-control image">
                                    <div class="alert alert-danger errorImage" style="color: red;font-size: 1rem"></div>
                                </div>

                                <div class="form-group">
                                    <label>Mô tả sản phẩm</label>
                                    <textarea name="description" id="editor1" cols="5" rows="5" class="form-control description"></textarea>
                                    <div class="alert alert-danger errorDescription" style="color: red;font-size: 1rem"></div>
                                </div>

                                <div class="form-group">
                                    <label>Danh mục sản phẩm</label>
                                    <select class="form-control cateProduct" name="idCategory"></select>
                                </div>

                                <div class="form-group">
                                    <label>Loại sản phẩm</label>
                                    <select class="form-control proTypeProduct" name="idProductType"></select>
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" class="ht">Hiển Thị</option>
                                        <option value="0" class="kht">Không Hiển Thị</option>
                                    </select>
                                </div>
                                <input type="submit" class="btn btn-success" value="Sửa">
                                <button type="reset" class="btn btn-primary">nhập lại</button>
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- delete Modal-->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn có muốn xóa ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="margin-left: 183px;">
                    <button type="button" class="btn btn-success delProduct">Có</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Không</button>
                    <div>
                    </div>
                </div>
            </div>
@endsection