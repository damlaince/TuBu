@extends('backend.layouts.default')
@section('head')
    <title>Siparişler</title>
@endsection
@section('content')
    <div class="card" id="app">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Ekleniş Tarihi</th>
                    <th>Sipariş Eden</th>
                    <th>Sipariş Sayısı</th>
                    <th>Toplam Fiyat</th>
                    <th>Durum</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($datas as $data)
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                            <strong>{{$data->_id}}</strong></td>
                        <td>{{date("d.m.Y H:i",strtotime($data->created_at))}}</td>
                        <td>{{$data->user->firstname}} {{$data->user->lastname}}<br> <small>{{$data->user->username}}</small></td>
                        <td>
                          {{count($data->product)}}
                        </td>
                        <td>{{$data->total_price}}₺</td>
                        <td><span class="badge bg-label-{{\Illuminate\Support\Facades\Config::get('tubuset.order_status_color')[$data->status]}} me-1">{{\Illuminate\Support\Facades\Config::get('tubuset.order_status')[$data->status]}}</span></td>
                        <td>
                            <button type="button" class="modals btn btn-sm btn-icon btn-outline-primary"
                                    data-href="{{route('panel.order.detail',$data->_id)}}"
                            ><i class='bx bx-edit-alt'></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

