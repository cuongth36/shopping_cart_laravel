@extends('layouts.smart')

@section('content')
<div class="order-succes">
   
        @if (session('success'))
            <div class="alert alert-success text-center">
                {{session('success')}}
                <p>Thông tin sản phẩm đã được gửi vào mail. Bạn vui lòng kiểm tra mail hoặc đăng nhập xem thông tin chi tiết đơn hàng</p>
            </div>
        @endif
</div>

@endsection