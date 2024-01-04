@extends('frontend.layouts.default')
@section('head')
    <title>Siparişlerim</title>
@endsection
@section('content')
<div class="container">
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>Sipariş Kodu</th>
                    <th>Oluşturulma Tarihi</th>
                    <th>Güncellenme Tarihi</th>
                    <th>Durum</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $data)
                    <tr>
                        <td>{{$data->code}}</td>
                        <td>{{date("d.m.Y H:i",strtotime($data->created_at))}}</td>
                        <td>{{date("d.m.Y H:i",strtotime($data->updated_at))}}</td>
                        <td> <span class="badge badge-{{\Illuminate\Support\Facades\Config::get('tubuset.order_status_color')[$data->status]}} me-1">{{\Illuminate\Support\Facades\Config::get('tubuset.order_status')[$data->status]}}</span></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
