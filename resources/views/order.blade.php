@extends('layouts.app')

@section('pagescss')
<link rel="stylesheet" href="/css/main/order.css">
@endsection

@section('title', 'Place order')

@section('content')
<section class="section">
    <div class="card">
      @foreach ($errors->all() as $error)
           <div class="alert alert-danger text-center mt-2  mb-1">{{$error}}</div>
      @endforeach
          <div class="card-top border-bottom text-center"><a href="{{ route('basket')}}"><h5><i class="fas fa-backward mr-1"></i>Back to cart</h5></a> <span id="logo">Place order</span> </div>
              <div class="row upper"></div>
              <div class="row">
                  <div class="col-md-7">
                      <div class="left border">
                          <div class="row"> <span class="header">Customer info</span>
                              <div class="icons"> <img src="https://img.icons8.com/color/48/000000/visa.png" /> <img src="https://img.icons8.com/color/48/000000/mastercard-logo.png" /> <img src="https://img.icons8.com/color/48/000000/maestro.png" /> </div>
                          </div>
                          <form action="{{route('new_order_place')}}" method="post">
                            <span>Name:</span> <input placeholder="{{Auth::check()?Auth::user()->name:'Enter name'}}" name="name">
                            <span>Mobile:</span> <input class="phone" onClick="setPos();" placeholder="{{Auth::check()?(Auth::user()->phone?Auth::user()->Format_Number_User:'Enter phone number'):'Enter phone number'}}" name="phone">
                            <span>E-MAIL:</span> <input placeholder="{{Auth::check()?Auth::user()->email:'Enter e-mail'}}" name="e-mail">
                            @csrf
                              <div class="row">
                                  <!-- <div class="col-4"><span>Город:</span> <input placeholder="Baku"></div> -->
                                  <div class="col-4"><span>Адрес:</span> <input placeholder="Enter address" name="address"></div>
                              </div> <!--<input type="checkbox" id="save_card" class="align-left"> <label for="save_card">Save card details to wallet</label>-->
                                <!-- <input type="submit" class="btn" value="Оформить заказ"> -->
                          <!-- </form> -->
                      </div>
                  </div>
                  <div class="col-md-5">
                      <div class="right border">
                          <div class="header">Order total <span class="prodcount">{{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }}</span></div><hr>
                          @foreach($products as $product)
                          <h6><a href="/{{ $product['code_cat'] }}/{{ $product['url_cat'] }}/{{ $product['prod_url'] }}">{{ $product['name'] }}</a></h6>
                          <div class="row item">
                              <div class="col-4 align-self-center"><a href="/{{ $product['code_cat'] }}/{{ $product['url_cat'] }}/{{ $product['prod_url'] }}"><img class="basketimg mr-1" src="@isset($product['img']){{Storage::disk('public')->exists('products/'.$product['id'].'/'.$product['img'])?Storage::url('products/'.$product['id'].'/'.$product['img']):'/img/products/no-img.png'}}@else{{'/img/products/no-img.png'}}@endisset"></a></div>
                              <div class="col-8">
                                  <div class="row"><b>{{ $product['cost'] }} AZN</b></div>
                                  <div class="row"><div class="btn-group form-inline">
                                    <div class="prodcount">{{ $product['qty'] }}</div>
                                    <a href="{{ route('basket-red', [ 'id' => $product['id'] ]) }}" class="fas fa-minus-square"></a>
                                    <a href="{{ route('basket-inc', [ 'id' => $product['id'] ]) }}" class="fas fa-plus-square"></a>
                                  </div></div>
                              </div>
                          </div>
                          <hr>
                          @endforeach
                          <div class="row lower">
                              <div class="col text-left">To pay:</div>
                              <div class="col text-right">{{ $totalPrice ?? '0'}} AZN</div>
                          </div>
                          <div class="row lower">
                              <div class="col text-left">Delivery:</div>
                              <div class="col text-right">Specified separately</div>
                          </div>
                          <!-- <div class="row lower">
                              <div class="col text-left"><b>Total to pay</b></div>
                              <div class="col text-right"><b>$ 46.98</b></div>
                          </div> -->
                          <input type="submit" class="btn" value="Place order">
                      </div>
                  </div>
                </form>
              </div>
          <div> </div>
      </div>
</section>
@endsection
@section('pagesjs')
<script src="/js/cursorpos.js"></script>
@endsection
