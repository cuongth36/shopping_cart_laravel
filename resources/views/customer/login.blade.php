@extends('layouts.smart')
@section('content')

{{-- <div class="container">
    <div id="form-login-customer">
        <h2>Đăng nhập để theo dõi đơn hàng</h2>
        <form action="{{route('customer.checklogin')}}" method="POST">
            @csrf
            <div class="form-group">
                <div class="user-info">
                    <label for="email">Email</label>
                    <input type="text" class="change-bg" id="email" name="email" placeholder="Nhập email">
                </div>   
            </div>
            <div class="form-group">
                <div class="user-info">
                    <label for="password">Mật khẩu</label>
                    <input type="password" class="change-bg" name="password" placeholder="Nhập mật khẩu">
                </div>
            </div>
            <div class="remember">
                <div class="form-check">
                    <label for="" class="form-check-label">
                        <input type="checkbox" name="remeber" class="form-check-input">
                        Ghi nhớ 
                    </label>
                </div>
                <div class="forgot-password">
                    <a href="">Quên mật khẩu?</a>
                </div>
            </div>
            <div class="message">
                @if(session('error'))
                     <div class="alert alert-danger">{{session('error')}}</div>
                @endif
            </div>
            <input type="submit" class="btn btn-primary submit-login" value="Đăng nhập">
            <div class="create-account">
                <a href="{{route('customer.register')}}">Tạo tài khoản mới</a>
            </div>
        </form>
    </div>
</div> --}}

<div class="container">
    <div class="row">
        <div class="col-md-12 min-vh-100 d-flex flex-column justify-content-center">
            <div class="row">
                <div class="col-lg-6 col-md-8 mx-auto">

                    <!-- form card login -->
                    <div class="card rounded shadow shadow-sm mr-bottom">
                        <div class="card-header">
                            <h3 class="mb-0">Đăng nhập</h3>
                        </div>
                        <div class="card-body">
                            <form class="form" action="{{route('customer.checklogin')}}" role="form" autocomplete="off" id="formLogin" novalidate="" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="uname1">Email</label>
                                    <input type="email" class="form-control form-control-lg rounded-0" name="email" id="uname1" required="">
                                    <div class="invalid-feedback">Email không được bỏ trống.</div>
                                </div>
                                <div class="form-group">
                                    <label>Mật khẩu</label>
                                    <input type="password" class="form-control form-control-lg rounded-0" id="pwd1" required="" name="password" autocomplete="new-password">
                                    <div class="invalid-feedback">Mật khẩu không được bỏ trống.</div>
                                </div>
                                {{-- <div>
                                    <label class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input">
                                      <span class="custom-control-indicator"></span>
                                      <span class="custom-control-description small text-dark">Nhớ tôi</span>
                                    </label>
                                </div> --}}
                                <div class="message">
                                    @if(session('error'))
                                         <div class="alert alert-danger">{{session('error')}}</div>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-success btn-lg float-right" id="btnLogin">Đăng nhập</button>
                                <div class="create-account">
                                    <a href="{{route('customer.register')}}">Tạo tài khoản mới</a>
                                </div>
                            </form>
                        </div>
                        <!--/card-block-->
                    </div>
                    <!-- /form card login -->

                </div>


            </div>
            <!--/row-->

        </div>
        <!--/col-->
    </div>
    <!--/row-->
</div>
<!--/container-->
@endsection