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
                            <td></td>
                            <td></td>
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
                            <form role="form">
                                <fieldset class="form-group">
                                    <label>Name</label>
                                    <input class="form-control name" name="name" placeholder="Nhập tên loại sản phẩm">
                                    <div class="alert alert-danger error" style="color: red;font-size: 1rem"></div>
                                </fieldset>
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control idCategory" name="idCategory"></select>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" class="ht">Hiển Thị</option>
                                        <option value="0" class="kht">Không Hiển Thị</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success updateProductType">Save</button>
                    <button type="reset" class="btn btn-primary">Làm Lại</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
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
                    <button type="button" class="btn btn-success delProductType">Có</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Không</button>
                    <div>
                    </div>
                </div>
            </div>
@endsection