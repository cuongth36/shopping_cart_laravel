@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Cập nhật bài viết
        </div>
        <div class="card-body">
        <form method="POST" action="{{route('post.update', $post->id)}}" enctype="multipart/form-data">
            @csrf
                <div class="form-group">
                    <label for="name">Tên bài viết</label>
                    <input class="form-control" type="text" name="title" id="name" value="{{$post->title}}">
                        @if(session('title_error'))
                            <small class="text-danger">{{session('title_error')}}</small>
                        @endif
                        @error('title')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                </div>

                <div class="form-group">
                    <label for="name">Slug</label>
                    <input class="form-control" type="text" name="slug" id="slug" value="{{$post->slug}}">
                    @error('slug')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Mô tả ngắn</label>
                    <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{$post->description}}</textarea>
                    @error('description')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content">Nội dung</label>
                    <textarea name="content" class="content" id="content" cols="30" rows="10">{{$post->content}}</textarea>
                </div>

                <div class="form-group">
                    <label for="">Danh mục</label>
                    <select class="form-control" id="" name="category_parent">
                      <option value="0">Chọn danh mục</option>
                      @foreach ($categories as $value)
                        {{$post->category_post_id}}
                        <option value="{{$value->id}}" @if($value->id == $post->category_id) {{'selected'}} @endif>{{str_repeat('- ', $value->level) . $value->title }}</option>
                      @endforeach
                    </select>
                    @if(session('category_error'))
                         <small class="text-danger">{{session('category_error')}}</small>
                    @endif
                   
                </div>

                <div class="form-group change-image-post">
                    <label for="description">Ảnh đại diện </label>
                  
                   <input type="file" name="file" class="form-control" id="change-image" value="{{url($post->thumbnail)}}">
                        @if (!empty($post->thumbnail))
                            <img src="{{url($post->thumbnail)}}" alt="{{$post->title}}" class="post-thumbnail thumbnail">
                        @endif
                        <img src="" alt="" class="thumbnail-preview thumbnail">
                    @error('file')
                        <small class="text-danger">{{$message}}</small>
                    @enderror

                    @if(session('file_error'))
                        <small class="text-danger">{{session('file_error')}}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="pendding" {{$post->status == 'pendding' ? 'checked' : ''}}>
                        <label class="form-check-label" for="exampleRadios1">
                          Chờ duyệt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="approve" {{$post->status == 'approve' ? 'checked' : ''}}>
                        <label class="form-check-label" for="exampleRadios2">
                          Công khai
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" value="update">Cập nhật</button>
        </form>
        </div>
    </div>
</div>    
@endsection
