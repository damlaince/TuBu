@extends('frontend.layouts.default')
@section('head')
    <title>Ödeme</title>
@endsection
@section('content')
    <div class="container py-5">
        <!-- For demo purpose -->
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-6">Ödeme Formu</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item"><a data-toggle="pill" href="#credit-card" class="nav-link active ">
                                        <i class="zmdi zmdi-card mr-2"></i> Kredi / Banka Kartı </a></li>
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">
                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                                <form role="form" action="{{route('front.payment')}}" method="POST">
                                    @csrf
                                    <div class="form-group"><label for="username">
                                            <h6>Kart Sahibi</h6>
                                        </label> <input type="text" name="fullname"
                                                        class="form-control" required></div>
                                    <div class="form-group"><label for="cardNumber">
                                            <h6>Kart Numarası</h6>
                                        </label>
                                        <div class="input-group"><input type="text" name="cardNumber" required
                                                                        class="form-control ">
                                            <div class="input-group-append"><span
                                                    class="input-group-text text-muted"> <i
                                                        class="zmdi zmdi-card mx-1"></i> <i
                                                        class="zmdi zmdi-paypal-alt mx-1"></i></span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group"><label><span class="hidden-xs">
                                                    <h6>Son Kullanma Tarihi</h6>
                                                </span></label>
                                                <div class="input-group"><input type="number" placeholder="MM" name="date_m"
                                                                                class="form-control" required > <input
                                                        type="number" placeholder="YY" name="date_y" class="form-control"
                                                       ></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-4"><label data-toggle="tooltip"
                                                                                title="Three digit CV code on the back of your card">
                                                    <h6>CVV <i class="fa fa-question-circle d-inline"></i></h6>
                                                </label> <input type="text" name="cvv"  class="form-control" required></div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="subscribe btn btn-primary btn-block shadow-sm">
                                            Ödeme Yap
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- End -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    body {
        background: #f5f5f5
    }

    .rounded {
        border-radius: 1rem
    }

    .nav-pills .nav-link {
        color: #555
    }

    .nav-pills .nav-link.active {
        color: white
    }

    input[type="radio"] {
        margin-right: 5px
    }

    .bold {
        font-weight: bold
    }
</style>



