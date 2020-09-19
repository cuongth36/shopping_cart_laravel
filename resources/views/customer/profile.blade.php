@extends('layouts.smart')

@section('content')
<div class="profile-customer">
  <div class="container">
    <div class="row">
        <div class="col-lg-12"><h3>Thông tin tài khoản</h3></div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link active" id="v-pills-account-tab" data-toggle="pill" href="#v-pills-account" role="tab" aria-controls="v-pills-account" aria-selected="true">Thông tin tài khoản</a>
              <a class="nav-link" id="v-pills-order-history-tab" data-toggle="pill" href="#v-pills-order-history" role="tab" aria-controls="v-pills-order-history" aria-selected="false">Lịch sử đặt hàng</a>
              <a href="{{route('logout')}}" class="logout">Logout</a>
            </div>
        </div>
        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-6">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab">
                  <div class="card rounded shadow shadow-sm mr-bottom">
                    <div class="card-body">
                        <form class="form" action="{{route('profile.update', $customer->id)}}" role="form" autocomplete="off" id="formRegister" novalidate="" method="POST">
                            @csrf
                            <h2>Cập nhập thông tin</h2>
                            <hr>
                            @if(session('status'))
                                <div class="alert alert-success">{{session('status')}}</div>
                            @endif
                            <div class="form-group">
                              <label for="fullname">Họ và tên</label>
                            <input type="text" class="change-bg form-control form-control-lg rounded-0"  id="fullname" name="fullname" value="{{$customer->name}}">
                              @error('fullname')
                                  <small class="text-danger">{{$message}}</small>
                              @enderror
                            </div>

                            <div class="form-group">
                                <label for="uname1">Email</label>
                                <input type="email" class="form-control form-control-lg rounded-0" name="email" id="uname1" required="" value="{{$customer->email}}" readonly>
                                <div class="invalid-feedback">Email không được bỏ trống.</div>
                            </div>

                            <div class="form-group">
                                <label>Mật khẩu</label>
                                <input type="password" class="form-control form-control-lg rounded-0" id="pwd1" required="" name="password" autocomplete="new-password">
                                <div class="invalid-feedback">Mật khẩu không được bỏ trống.</div>
                            </div>
                            
                          
                            <div class="form-group">
                                <label for="psw-repeat">Xác nhận mật khẩu</label>
                                <input type="password" class="change-bg form-control form-control-lg rounded-0"  id="psw-repeat" name="password_confirmation">
                                @error('password')
                                  <small class="text-danger">{{$message}}</small>
                                @enderror

                                @if (session('error'))
                                    <small class="text-danger">{{session('error')}}</small>
                                @endif
                            </div>

                            <div class="form-group">
                              <label for="address">Địa chỉ</label>
                               <input type="text" class="change-bg form-control form-control-lg rounded-0"  id="address" name="address" value="{{$customer->address}}">
                              @error('address')
                               <small class="text-danger">{{$message}}</small>
                              @enderror
                            </div>
                          
                            <div class="form-group">
                              <label for="phone">Số điện thoại</label>
                              <input type="text" class="change-bg form-control form-control-lg rounded-0"  id="phone" name="phone" value="{{$customer->phone}}">
                              @error('phone')
                                <small class="text-danger">{{$message}}</small>
                              @enderror
                            </div>
                            <button type="submit" class="btn btn-success btn-lg " id="btnLogin">Cập nhật</button>
                        </form>
                    </div>
                    <!--/card-block-->
                  </div>
                </div>
                <div class="tab-pane fade" id="v-pills-order-history" role="tabpanel" aria-labelledby="v-pills-order-history-tab">
                      <form action="" method="POST">
                        <table class="table table-striped order-history">
                          <thead>
                            <tr>
                              <th scope="col">STT</th>
                              <th scope="col">Tên sản phẩm</th>
                              <th scope="col">Số lượng</th>
                              <th scope="col">Giá tiền</th>
                              <th scope="col">Màu sắc</th>
                              <th scope="col">Size</th>
                              <th scope="col">Ngày mua</th>
                              {{-- <th scope="col">Tác vụ</th> --}}
                            </tr>
                          </thead>
                          <tbody>
                            @php
                                $count = 0; 
                                $total_price = [];
                            @endphp
                            @foreach ($order_history as $order)
                                
                                @php
                                  $count++; 
                                  $total_price[]=$order->total_qty*$order->price;
                                
                                @endphp
                                <tr>
                                <th scope="row">{{$count}}</th>
                                  <td>{{$order->product_name}}</td>
                                  <td>{{$order->total_qty}}</td>
                                  <td>{{number_format($order->price,0, '', '.')}}đ</td>
                                  <td>{{$order->color_name}}</td>
                                  <td>{{$order->size_name}}</td>
                                  <td>{{$order->date_order}}</td>
                                  {{-- @php
                                      
                                      $date = $order->date_order;
                                      $new_date = date(strtotime('+30 minutes', strtotime($date)));
                                      $date_now = strtotime("now");
                                  @endphp
                                  @if ($order->product_id == $order->prd_id)
                                      
                                    <td class="{{$date_now > $new_date ? 'disabled-refund' : ''}}"><a href="" class="btn-danger "><i class="fa fa-trash"></i></a></td>
                                  @endif --}}
                                  
                                </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </form>  
                    <div class="total-price-order">
                      <span>Tổng:</span>
                      <span><b>{{number_format(array_sum($total_price), 0, '', '.') }}đ</b></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

@endsection