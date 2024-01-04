<header class="header-v4">
<div class="container-menu-desktop">
    <!-- Topbar -->

    <div class="wrap-menu-desktop how-shadow1">
        <nav class="limiter-menu-desktop container">
            <!-- Logo desktop -->
            <a href="{{route('front.home')}}" class="logo">
                TuBu
            </a>
            <!-- Menu desktop -->
            <div class="menu-desktop">
                <ul class="main-menu">
                    @foreach($__categoriesüst->get() as $categoryüst)
                        <li class="active-menu">
                            <a href="{{route('front.product.list',$categoryüst->seo->keyword)}}">{{$categoryüst->name}}</a>
                            @if($categoryüst->childs)
                                <ul class="sub-menu">
                                    @foreach($categoryüst->childs as $categoryalt)
                                        <li><a href="{{route('front.product.list',[$categoryüst->seo->keyword, $categoryalt->seo->keyword])}}">{{$categoryalt->name}}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach

                </ul>

            </div>

            <!-- Icon header -->
            <div class="wrap-icon-header flex-w flex-r-m">
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li class="active-menu">
                            <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                                <i class="zmdi zmdi-account"></i>
                            </div>
                            <ul class="sub-menu">
                                <li><a>Hoşgeldin {{auth()->user()->username}}</a></li>
                                <li><a href="{{route('front.order.list')}}">Siparişlerim</a> </li>
                                <li><a href="{{route('front.logout')}}">Çıkış Yap</a> </li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <a href="{{route('front.cart')}}" class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="2">
                    <i class="zmdi zmdi-shopping-cart"></i>
                </a>

                <a href="#" class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti" data-notify="0">
                    <i class="zmdi zmdi-favorite-outline"></i>
                </a>
            </div>
        </nav>
    </div>
</div>
</header>
