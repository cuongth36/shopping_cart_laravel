@extends('layouts.smart')
@section('content')
<div class="main-content">
    <div class="container">
        @if (session('cart_success'))
            <div class="alert alert-success text-center">{{session('cart_success')}}</div>
        @endif
    </div>
    <div class="title-page">
        <h3>Giỏ hàng</h3>
        
    </div>
    <div class="container">
        @if (Cart::total() > 0)
            <div class="cart-destroy">
                <div class="home">
                    <div class="icon-home">
                        <i class="fa fa-home"></i>
                    </div>
                    <a href="{{route('home')}}">Tiếp tục mua hàng tại đây?</a>
                </div>
                <div class="cart-destroy-item">
                    <a href="{{route('cart.destroy')}}">Xóa giỏ hàng</a>
                </div>
            </div>
        @endif
     
    </div>
    <div class="cart-box-container">
        <div class="container container-ver2">
            <div class="row">
                <div class="col-md-12">
                    @if (Cart::count() > 0)
                        <div class="cart-wrapper">
                            @include('cart/data-content')
                            <div class="contact-form coupon">
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label class=" control-label" for="inputfname">Coupon</label>
                                        <input type="text" class="form-control" id="inputfname" placeholder="Enter your Coupon code...">
                                        <button value="Submit" class="btn link-button link-button-v2 hover-white color-red" type="submit">Áp dụng</button>
                                    </div>

                                </form>
                            </div>
                            <div class="cart-total">
                                <p>Tổng: <span class="total-item">{{Cart::total()}}đ</span></p>
                            </div>
                            <div class="pre-checkout">
                                <a class="btn btn-primary link-button hover-white checkout" href="{{route('cart.pre_checkout')}}" title="Proceed to checkout">Thanh toán</a>
                            </div>

                        </div>
                    @else
                        <div class="cart-empty">
                            <p>Không có hàng trong giỏ</p>
                            <a href="{{route('home')}}">Bấm vào đây để tiếp tục mua hàng</a>
                        </div>
                    @endif
                    
                    
                </div>
            </div>
           
           
        </div>
        <!-- End container -->
    </div>
    <!-- End cat-box-container -->
</div>
@endsection
