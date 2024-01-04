@extends('frontend.layouts.default')
@section('head')
    <title>Sepetim</title>
@endsection
@section('content')
    <form class="bg0 p-t-75 p-b-85" action="{{route('front.cart')}}" method="POST">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        <div class="wrap-table-shopping-cart">
                            <table class="table-shopping-cart">
                                <tr class="table_head">
                                    <th class="column-1">Ürün</th>
                                    <th class="column-2"></th>
                                    <th class="column-3">Fiyat</th>
                                    <th class="column-4">Adet</th>
                                    <th class="column-5">Toplam</th>
                                </tr>
                                @if($datas && isset($datas['product']) && $datas['product'])
                                    @foreach($datas['product'] as $data)
                                        <tr class="table_row">
                                            <td class="column-1">
                                                <button class="how-itemcart1" name="delete"
                                                        value="{{$data['product_id']}}">
                                                    <img src="{{asset($data['image'])}}" alt="IMG">
                                                </button>
                                            </td>
                                            <td class="column-2">{{$data['name']}}</td>
                                            <td class="column-3">{{$data['price']}}₺
                                            </td>
                                            <td class="column-4">
                                                <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                    <div
                                                        class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m quantity-minus"
                                                        data-id="{{$data['product_id']}}">
                                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                                    </div>
                                                    <input class="mtext-104 cl3 txt-center num-product quantity-input"
                                                           id="{{$data['product_id']}}" type="number"
                                                           name="num-product[{{$data['product_id']}}]"
                                                           value="{{$data['custom']}}">
                                                    <div
                                                        class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m quantity-plus"
                                                        data-id="{{$data['product_id']}}">
                                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="column-5">{{$data['total_price']}}₺</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="4">Sepette Ürün Bulunmamaktadır</td>
                                    </tr>
                                @endif
                            </table>
                        </div>

                        <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                            <button
                                class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10"
                                name="update" value="cart">
                                Sepeti Güncelle
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            Sepet Toplamı
                        </h4>

                        @if(isset($datas['total']) && $datas['total'] && $datas['total'] > 0)
                            <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                                <div class="size-208 w-full-ssm">
								<span class="stext-110 cl2">
									Adres:
								</span>
                                </div>

                                <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">

                                    <div class="p-t-15">
                                        <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                            <select class="js-select2 form-select" name="country">
                                                <option value="">Ülke Seçiniz</option>
                                                @foreach(Config::get('tubuset.country') as $key => $value)
                                                    <option value="{{$key}}" {{isset($datacart['adress']['country']) && $datacart['adress']['country'] == $value ? 'selected' :''}}>{{$value}}</option>
                                                @endforeach
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>
                                        <div class="bor8 bg0 m-b-12">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="state" value="{{isset($datacart['adress']['state']) ? $datacart['adress']['state'] :''}}"
                                                   placeholder="İl /  İlçe">
                                        </div>

                                        <div class="bor8 bg0 m-b-22">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="street" value="{{isset($datacart['adress']['street']) ? $datacart['adress']['street'] :''}}"
                                                   placeholder="Mahalle / Sokak">
                                        </div>
                                        <div class="bor8 bg0 m-b-22">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" value="{{isset($datacart['adress']['no'])? $datacart['adress']['no'] :''}}"
                                                   name="no"
                                                   placeholder="Bina No / Kapı No">
                                        </div>

                                        <div class="bor8 bg0 m-b-22">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" value="{{isset($datacart['adress']['postcode']) ? $datacart['adress']['postcode'] :''}}"
                                                   name="postcode"
                                                   placeholder="Posta Kodu">
                                        </div>

                                        <div class="flex-w">
                                            <button
                                                class="flex-c-m stext-101 cl2 size-115 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer"
                                                name="update" value="adress">
                                                Adres Güncelle
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="flex-w flex-t p-t-27 p-b-33">
                            <div class="size-208">
								<span class="mtext-101 cl2">
									Toplam:
								</span>
                            </div>

                            <div class="size-209 p-t-1">
								<span class="mtext-110 cl2">
									{{isset($datas['total']) && $datas['total'] ? $datas['total']:0}}₺
								</span>
                            </div>
                        </div>

                        @if(isset($datas['total']) && $datas['total'] && $datas['total'] >0 && isset($datacart['adress']) && !empty($datacart['adress']))
                            <a href="{{route('front.payment')}}" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                                Ödemeye Devam Et
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
