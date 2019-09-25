@extends('admin.layouts.master')
@section('title')
    Thêm loại sản phẩm
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">loại sản phẩm</h6>
        </div>
        <div class="row" style="margin: 5px">
            <div class="col-lg-12">
                <form role="form" action="{{ route('producttype.store') }}" method="post">
                    @csrf
                    <fieldset class="form-group">
                        <label>Name</label>
                        <input class="form-control" name="name" placeholder="Nhập tên loại sản phẩm">
                        @error('name')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </fieldset>

                    <div class="form-group">
                        <label>category</label>
                        <select class="form-control" name="idCategory">
                            @foreach($category as $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status">
                            <option value="1">Hiển Thị</option>
                            <option value="0">Không Hiển Thị</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">thêm</button>
                    <button type="reset" class="btn btn-primary">nhập lại</button>
                </form>
            </div>
        </div>
    </div>
@endsection