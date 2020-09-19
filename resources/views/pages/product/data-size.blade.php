{{-- <div class="change-color-size"> --}}
  @if (count($product_color) > 0)
  <div class="product-color">
    <span id="title-color">Màu sắc:</span>
    <ul>
      @foreach ($product_color as $color)
          <li class="color-item">
           
            <span name="color_product" style="background-color:{{$color->color_code}}" data-toggle="tooltip">
             @csrf
            <input type="radio" name="product-color" value="{{$color->id}}" data-size="{{$color->size_id}}" data-qty ={{$color->amount}} class="color-info">
            <input type="hidden" name="slug-product" class="slug-product" value="{{$color->product_slug}}">
            <input type="hidden" name="action-change-size" value="{{route('product.change', [$color->product_slug, '.html'])}}" class="action-change-size">
            </span>
          </li>
      @endforeach
    </ul>
    <div class="error">
      @error('product-color')
        <small class="text-danger">{{$message}}</small>    
      @enderror
    </div>
  
  </div>
  @endif
  
@if (count($product_size) >0)
<div class="product-size">
  <span>Chọn bộ nhớ:</span>
  <select name="product-size" id="size-item" class="size-info custom-select mr-sm-2">
      @foreach ($product_size as $size)
              <option value="{{$size->id}}" class="size-active">{{$size->name}}</option>
      @endforeach
  </select>
  <div class="error">
    @error('product-size')
    <small class="text-danger">{{$message}}</small>    
    @enderror
  </div>
</div>
@endif
{{-- </div> --}}






