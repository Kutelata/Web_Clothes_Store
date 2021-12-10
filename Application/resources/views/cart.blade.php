@extends('layouts.master')
@section('title','Shoe - Cart')

@section('main')
    <div class="ps-content pt-80 pb-80">
        <div class="ps-container">
            <div class="ps-cart-listing" id="list-cart">
                @if(Session::has('Cart')!=null)
                    <table class="table ps-cart__table">
                        <thead>
                        <tr>
                            <th>All Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(Session::get('Cart')->products as $item)
                            <tr>
                                <td>
                                    <a class="ps-product__preview" href="{{route('product_detail')}}?productId={{$item['productInfo']->productId}}">
                                        <img class="mr-15" style="width:100px !important;"
                                             src="{{asset('resources/images/shoe/')}}/{{$item['productInfo']->image}}.jpg"
                                             alt=""> {{$item['productInfo']->name}} {{$item['size']}}
                                    </a>
                                </td>
                                <td>${{$item['productInfo']->price}}</td>
                                <td>
                                    <div class="form-group--number">
                                        <input id="quantity-item-{{$item['productInfo']->productId}}-{{$item['sizeId']}}"
                                               onclick="SaveListItemCart({{$item['productInfo']->productId}},{{$item['sizeId']}})"
                                               class="form-control" type="number" value="{{$item['quantity']}}">
                                        <input id="sizeId" hidden value="{{$item['sizeId']}}">
                                    </div>
                                </td>
                                <td>${{$item['price']}}</td>
                                <td>
                                    <div class="ps-remove"
                                         onclick="DeleteListItemCart({{$item['productInfo']->productId}},{{$item['sizeId']}})">
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="ps-cart__actions">
                        <div class="ps-cart__promotion">
                            <div class="form-group">
                                <a class="ps-btn ps-btn--gray text-center" href="{{route('product_list')}}">Continue Shopping</a>
                            </div>
                        </div>
                        <div class="ps-cart__total">
                            <h3>Total Price: <span> ${{(Session::get('Cart')->totalPrice)}}</span></h3><a class="ps-btn"
                                                                                                          href="{{route('checkout')}}">Process
                                to
                                checkout<i class="ps-icon-next"></i></a>
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger" style="margin: 15px" role="alert">
                        Your cart is empty!
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function DeleteListItemCart(id, $sizeid) {
            $.ajax({
                url: 'Delete-Item-List-Cart/' + id + '/' + $sizeid,
                type: 'GET',

            }).done(function (response) {
                RenderCart(response)
                alertify.success('Removed product from your cart');
            });
        }

        function RenderCart(response) {
            $("#list-cart").empty();
            $("#list-cart").html(response);

        }

        function SaveListItemCart(id, sizeid) {
            if($("#quantity-item-" + id + "-" + sizeid).val() < 1){
                DeleteListItemCart(id,sizeid);
            }else{
                $.ajax({
                    url: 'Save-Item-List-Cart/' + id + '/' + $("#quantity-item-" + id + "-" + sizeid).val() + '/' + sizeid,
                    type: 'GET',

                }).done(function (response) {
                    RenderCart(response)
                    alertify.success('Update success');
                });
            }
        }
    </script>
@endsection
