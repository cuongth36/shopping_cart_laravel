@extends('layouts.smart')

@section('content')
 <!-- Main content -->
 <div class="main-content-st2">
  <div class="loader-wrapper">
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
  </div>

  
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        @if (request()->slug)
          <div class="breadcrumb-custom">{{Breadcrumbs::render('product_category.show', request()->slug) }}</div>
        @else
          <div class="breadcrumb-custom">{{Breadcrumbs::render('product.show') }}</div>
        @endif
       
      </div>
    </div>
  </div>
 
    <!-- Shop Page Full Width -->
    <div class="container">
        <section class="shoppage-fullwidth pd-15">
          <div class="shoppage-fullwidth-box overfl-visible">
              <div class="shoppage-fullwidth-wrapper">
                  <div class="shoppage-fullwidth-action">
                    <div class="row">
                        <div class=" col-md-6 col-lg-6 col-xl-9 custom-order-2">
                          <div class="filter-left">
                              <div class="row">
                                <div class="col-xl-4 col-lg-6 d-none-19 ">
                                  <div class="filter-left-showing">
                                    <p class="filter-left-showing-text mb-0">Showing 1–16 of 9 results</p>
                                  </div>
                                </div>
                                <div class="col-xl-8 col-lg-6 col-19px-12 d-none-67px">
                                  <div class="filter-left-price" id="price-fillter">
                                    <div class="filter-left-price-name">Giá</div>
                                    @php
                                        $request = '';
                                        if(request()->slug){
                                          $request = request()->slug;
                                        }
                                       
                                    @endphp
                                    <form class="filter-left-price-range">
                                      <div data-role="rangeslider" >
                                        @csrf
                                        <input type="hidden" name="action_price" class="action-fillter-price" data-action="{{route('product.fillter')}}">
                                        <input type="hidden" name="request_url" class="action-request-url" data-request= {{$request}}>
                                        <input type="text" class="js-range-slider" id="price-change" name="min_range" value="" data-min="{{$product_price[0]}}" data-max= "{{$product_price[1]}}"/>
                                      </div>
                                    </form>
                                    <div class="submit-fillter-price">
                                          <input type="submit" class="btn btn-primary" value="Lọc giá">
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div>
                      <div class="col-md-6 col-lg-6 col-xl-3 custom-order-1">
                          <div class="filter-right">
                            <ul class="filter-right-list mb-0">
                                <li class="filter-right-item ">
                                    <div class="filter-right-show">
                                      <button class=" category-show">Danh mục
                                          <i class="lnr lnr-chevron-down"></i>
                                      </button>
                                      <ul class=" list-category">
                                        @foreach ($categories as $value)    
                                        <li class="filter-right-show-item"><a class="filter-right-show-link" href="{{route('product_category.show', [$value->slug, '.html'])}}">{{$value->title}}</a></li>
                                        @endforeach
                                      </ul>
                                    </div>
                                </li>
                                
                              <li class="filter-right-item ">
                                <div class="filter-right-show">
                                  <button class=" category-show">Sắp xếp
                                      <i class="lnr lnr-chevron-down"></i>
                                  </button>
                                    <ul class=" list-category">
                                        <li role="presentation" class="filter-right-show-item">
                                          <a href="{{ request()->fullUrlWithQuery(['order_by' => 'asc'])}}" class="{{request()->order_by == 'asc' ? 'active' : ''}}">Tên a-z</a>
                                        </li>
                                        <li role="presentation" class="filter-right-show-item">
                                          <a  href="{{request()->fullUrlWithQuery(['order_by' => 'desc'])}}" class="{{request()->order_by == 'desc' ? 'active' : ''}}">Tên z-a</a>
                                        </li>
                                        <li role="presentation" class="filter-right-show-item">
                                          <a href="{{request()->fullUrlWithQuery(['order_by' => 'price_asc'])}}" class="{{request()->order_by == 'price_asc' ? 'active' : ''}}">Giá thấp đến cao</a>
                                        </li>
                                        <li role="presentation" class="filter-right-show-item">
                                          <a href="{{request()->fullUrlWithQuery(['order_by' => 'price_desc'])}}" class="{{request()->order_by == 'price_desc' ? 'active' : ''}}">Giá cao đến thấp</a>
                                        </li>
                                    </ul>
                                </div>
                              </li>
                            </ul>
                          </div>
                        </div>
                    </div>
                  </div>
              </div>
          </div>
        </section>
    </div>



    
   <!-- Product Shop Page Full Width -->
   <section class="popular-product product-shoppage-fullwidth result-fillter">
      <div class="container">
        <div class="row result-load-more">
           @include('pages/product/data-product-list')
        </div>
       @if (!request()->slug)
        <div class="load-more">
            @csrf
            <input type="hidden" name="action_load_more" class="action-load-more" value="{{route('product.loadmore')}}">
            <button class="btn btn-primary load-more-item">Xem thêm</button>
        </div>
        @else
          <div class="load-more-category">
            @csrf
            <input type="hidden" name="action_load_more" class="action-load-more" value="{{route('product.cate.loadmore', [request()->slug ])}}">
            <button class="btn btn-primary load-more-item">Xem thêm</button>
        </div>
       @endif
        
       
        
      </div>
    </section>

    
  </div>    
@endsection