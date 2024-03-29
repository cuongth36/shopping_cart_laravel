@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm sản phẩm
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('product.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="title">Tên sản phẩm</label>
                            <input class="form-control" type="text" name="title" id="title">
                            @error('title')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input class="form-control" type="text" name="slug" id="slug">
                            @error('slug')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Giá bán</label>
                            <input class="form-control" type="text" name="price" id="price">
                            @error('price')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="discount">Số % giảm giá</label>
                            <input class="form-control" type="number" name="discount" id="discount">
                            @error('discount')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label for="quantity">Số lượng</label>
                            <input class="form-control" type="number" min='1' name="quantity" id="quantity">
                            @error('quantity')
                                <small class="text-danger">{{$message}}</small>
                             @enderror
                        </div> --}}
                        
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="description">Mô tả sản phẩm</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="12"></textarea>
                            @error('description')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label for="color">Màu sản phẩm</label>
                            <select class="js-color-multiple form-control" name="colors[]" multiple="multiple">
                                <option value="">Chọn màu sản phẩm</option>
                                    @foreach ($colors as $color)
                                        <option value="{{$color->id}}">{{$color->title}}</option>
                                    @endforeach
                            </select>
                            @error('colors')
                                <small class="text-danger">{{$message}}</small>
                             @enderror
                        </div> --}}
                        {{-- <div class="form-group">
                            <label for="color">Size sản phẩm</label>
                            <select class="js-size-multiple form-control" name="sizes[]" multiple="multiple">
                                <option value="">Chọn màu sản phẩm</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{$size->id}}">{{$size->name}}</option>
                                    @endforeach
                            </select>
                            @error('sizes')
                                <small class="text-danger">{{$message}}</small>
                             @enderror
                        </div> --}}
                        
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Thêm thuộc tính:</label>
                            <a href="javascript:void(0);" class="add_button btn btn-primary" title="Add field">Thêm thuộc tính</a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="field_wrapper">
                            <div class="append-item">
                                <div class="row attr-item">
                                    <div class="col-lg-3 col-md-3">
                                        <label for="color">Màu sản phẩm</label>
                                        <select class="js-color-multiple form-control" name="colors[]">
                                            <option value="">Chọn màu sản phẩm</option>
                                                @foreach ($colors as $color)
                                                    <option value="{{$color->id}}">{{$color->title}}</option>
                                                @endforeach
                                        </select>
                                        @error('colors')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <label for="color">Size sản phẩm</label>
                                        <select class="js-size-multiple form-control" name="sizes[]" >
                                            <option value="">Chọn size sản phẩm</option>
                                                @foreach ($sizes as $size)
                                                    <option value="{{$size->id}}">{{$size->name}}</option>
                                                @endforeach
                                        </select>
                                        @error('sizes')
                                            <small class="text-danger">{{$message}}</small>
                                         @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-3 mr-top-attr">
                                            
                                            <label for="quantity">Số lượng</label>
                                            <input  type="number" min='1' name="quantity[]" id="quantity">
                                            @error('quantity')
                                                <small class="text-danger">{{$message}}</small>
                                             @enderror
                                     
                                    </div>
                                    <div class="col-lg-3 col-md-3 mr-top-attr">
                                        <a href="javascript:void(0);" class="remove_button btn btn-primary" title="Add field">Xóa thuộc tính</a>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="content">Chi tiết sản phẩm</label>
                    <textarea name="content" class="form-control content"  id="content" cols="30" rows="8"></textarea>
                    @error('content')
                        <small class="text-danger">{{$message}}</small>    
                    @enderror
                </div>

                <div class="form-group thumb-product">
                    <label for="description">Ảnh đại diện </label>
                   <input type="file" id="change-image-product" name="file" class="form-control">
                    <img src="" alt="" class="feature-product thumbnail">
                    @error('file')
                        <small class="text-danger">{{$message}}</small>
                    @enderror

                    @if(session('file_error'))
                        <small class="text-danger">{{session('file_error')}}</small>
                    @endif
                </div>

                <div class="form-group thumbnail-feature-wrapper">
                    <label for="description">Ảnh chi tiết </label>
                   <input type="file" id="feature-image" name="feature-image[]" class="form-control feature-image" multiple>
                   <img src="" alt="" class="preview-feature-image">
                    @error('feature-image')
                        <small class="text-danger">{{$message}}</small>
                    @enderror

                    @if(session('upload_error'))
                        <small class="text-danger">{{session('upload_error')}}</small>
                    @endif
                </div>
                


                <div class="form-group">
                    <label for="">Danh mục</label>
                    <select class="form-control" id="" name="category_parent">
                        <option value="0">Chọn danh mục</option>
                        @foreach ($categories as $item)
                            <option value="{{$item->id}}">{{str_repeat('-',$item->level).$item->title}}</option>    
                        @endforeach
                    </select>
                    @if(session('category_error'))
                        <small class="text-danger">{{session('category_error')}}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="product-hot">Sản phẩm nổi bật:</label>
                    <input type="checkbox" name="product_hot" id="product-hot" class="mr-left" value="1">
                    
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="0" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Chờ duyệt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="1">
                        <label class="form-check-label" for="exampleRadios2">
                            Công khai
                        </label>
                    </div>
                </div>



                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div> 
@endsection