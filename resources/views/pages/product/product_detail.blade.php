@extends('layouts.smart')
@section('content')
 <!-- PRODUCT DETAIL V3 -->
<div class="container">
  <div class="row">
    <div class="col-md-12">
      @if (request()->slug)
        <div class="breadcrumb-custom">{{Breadcrumbs::render('product.detail', request()->slug) }}</div>
      @endif
     
    </div>
  </div>
</div>
 <section class="product-detail-v1 padding-section">
    <div class="container">
      <div class="product-detail-v1-wrapper">
        <div class="row">
          <div class="col-md-6">
            <div class="product-detail-v3-image">
              <div class="product-detail-v3-order row">
                <div class="order2-prodetail-v3 custom-col-md-10-prod">
                  <div class="slider slider-single change-pr-img">
                    <img src="{{url($products->thumbnail)}}" alt="Product" class="img-fluid">
                  </div>
                </div>
                @if (count($feature_image) > 0)
                  <div class="order1-prodetail-v3 custom-col-md-2-prod">
                    <div class="slider slider-nav">
                      @foreach ($feature_image as $image)
                              @foreach ($image as $value)
                                  @if (!empty($value))
                                    <div class="product-detail-v3-image change-image">
                                      <img src="{{url($value)}}" alt="Product" class="img-fluid" data-image="{{url($value)}}">
                                  </div>
                                  @endif
                              @endforeach
                      @endforeach
                    </div>
                </div>
                @endif
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-12">
                  <div class="product-detail-v1-info pro-detail-v2-pt">
                    <h1 class="product-detail-v1-title mb-0">{{$products->title}}</h1>
                    
                    <div class="product-detail-v1-meta">
                      <div class="product-detail-v1-price">
                          @if (!empty($products->discount))
                          <span class="cost">{{number_format($products->price, 0, '', '.')}}đ</span>
                          @else
                          <span class="price">{{number_format($products->price, 0, '', '.')}}đ</span>
                          @endif
                          
                          @if (!empty($products->discount))
                          <span class="sale">
                           
                              {{number_format((1-($products->discount/100))*$products->price, 0, '', '.')}}đ  
                          </span>
                          @endif
                      </div>
                    </div>
                    <p class="mb-0">
                      {{$products->description}}
                    </p>
                    <form action="{{route('cart.add', $products->id)}}" method="GET" id="form-submit-product">
                      @csrf
                      <div id="form-add-product">
                        <div class="product-detail-v1-action product-info-detail">
                        
                          @include('pages/product/data-size')

                          <div class="product-out-stock">
                            <p>Sản phẩm tạm hết hàng</p>
                          </div>

                          <div class="product-detail-buy">
                            <div class="quanlity" id="order-qty">
                              <button type="button" id="minus" class="subtraction">-</button>
                                <input type="text" class="quanlity-num" name="qty" pattern="[0-9]*" min="1" max="{{$products->quantity}}" value="1" readonly>
                              <button type="button" id="plus" class="addition">+</button>
                            </div>
                            <div class="add-product">
                              <button type="submit" id="add-to-cart" class="btn-addproduct">Thêm giỏ hàng</button>
                            </div>
                          </div>

                        </div>
                      </div>
                    </form>
                    <div class="product-detail-v1-attr">
                    <p class="mb-0"><span>Danh mục:</span><a href="{{route('product_category.show', [$products->categories->slug, '.html'])}}"> {{$products->categories->title}}.</a></p>
                    </div>
                  </div>
             
              </div>
            </div>
          </div>
        </div>
       
        <div class="row">
          <div class="col-md-12">
            <div class="product-detail-tabs-content pro-dt-tab-content-pt">
              <nav> 
                <div class="nav nav-fill product-detail-tabs d-flex justify-content-center" id="nav-tab" role="tablist">
                  <a class="product-detail-tabs-item active" id="nav-home-tab" data-toggle="tab" href="#pro-detail-Description" role="tab" aria-controls="pro-detail-Description" aria-selected="true">Mô tả sản phẩm</a>
                  <a class="product-detail-tabs-item" id="nav-profile-tab" data-toggle="tab" href="#pro-detail-Additionalinfo" role="tab" aria-controls="pro-detail-Additionalinfo" aria-selected="false">Thông tin chi tiết</a>
                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="pro-detail-Description" role="tabpanel" aria-labelledby="nav-home-tab">
                    {{$products->description}}
                </div>
                <div class="tab-pane fade" id="pro-detail-Additionalinfo" role="tabpanel" aria-labelledby="nav-profile-tab">
                  {{$products->content}}
                </div>
                
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
    <section class="popular-product deal-of-the-week product-detail-v1-related js-slider-item">
      <div class="container">
        <div class="row">
          <div class="deal-of-the-week-title box-title">
            <h2 class="dotw-title des-title">Sản phẩm tương tự</h2>
          </div>
        </div>
        <div class="row deal-of-the-week-inner">
          <div class="product-item owl-carousel owl-theme">
            @foreach ($product_release as $item)
                <div class="">
                  <div class="dotw-item box-item">
                    <div class="dotw-item-image box-item-image">
                    <a href="{{route('product.detail', [$item->slug, '.html'])}}"><img src="{{url($item->thumbnail)}}" alt="{{$item->title}}"></a>
                    </div>
                    <div class="dotw-item-info box-item-info">
                      <h3><a href="{{route('product.detail', [$item->slug, '.html'])}}" class="dotw-item-name item-name">{{$item->title}}</a></h3>
                      <div class="dotw-price-rate item-price-rate">
                        <div class="dotw-price item-price">
                          @if (!empty($item->discount))
                              <span class="cost">{{number_format($item->price, 0, '', '.')}}đ</span>
                              @else
                              <span class="price">{{number_format($item->price, 0, '', '.')}}đ</span>
                              @endif
                              
                              @if (!empty($item->discount))
                              <span class="sale">
                              
                                  {{number_format((1-($item->discount/100))*$item->price, 0, '', '.')}}đ
                                  
                              </span>
                            @endif
                        </div>

                      </div>                                                                                         
                    </div>
                    <div class="offer">
                        @if (!empty($item->discount))
                            <div class="percent">-{{$item->discount}}%</div>
                        @endif
                    </div>
                    
                  </div>
                </div>         
            @endforeach
       
          </div> 
        </div>
      </div>
    </section>
  </section>
@endsection