@extends('backend.layouts.default')
@section('head')
    <title>Ürünler</title>
@endsection
@section('content')
    <div class="card" id="app">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Ekleniş Tarihi</th>
                    <th>Kategori</th>
                    <th>Ürün Adı</th>
                    <th>Ürün Rengi</th>
                    <th>Bedenler</th>
                    <th>Stok Sayısı</th>
                    <th>Fiyat</th>
                    <th>Durum</th>
                    <th>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-primary modals"
                                data-href="{{route('panel.product.form')}}"
                        >
                            <i class='bx bx-plus'></i>
                        </button>
                    </th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($datas as $data)
                    <tr>
                        <td><ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center" >
                                @foreach($data->images as $image)
                                    <li
                                        data-bs-toggle="tooltip"
                                        data-popup="tooltip-custom"
                                        data-bs-placement="top"
                                        class="avatar avatar-xs pull-up rounded-circle"
                                        title="{{$image}}"
                                    >
                                        <img src="{{asset($image)}}" class="rounded-circle" />
                                    </li>
                                @endforeach
                            </ul></td>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                            <strong>{{$data->_id}}</strong></td>
                        <td class="text-center">{{date("d.m.Y H:i",strtotime($data->created_at))}}</td>
                        <td class="text-center">{{$data->category->name}}</td>
                        <td class="text-center">{{$data->name}}</td>
                        <td><ul class="users-list m-0 avatar-group d-flex align-items-center" >
                                <li
                                    data-bs-toggle="tooltip"
                                    data-popup="tooltip-custom"
                                    data-bs-placement="top"
                                    class="avatar avatar-xs pull-up rounded-circle"
                                    title="{{$data->color}}"
                                    style="background: {{$data->color}}; list-style-type:none;"
                                >
                                </li></ul></td>
                        <td class="text-center"> @foreach($data->sizes as $size)
                                <span
                                    class="badge bg-label-primary me-1">{{$size}}</span>
                            @endforeach</td>
                        <td class="text-center">{{$data->custom}}</td>
                        <td class="text-center">{{$data->price}}</td>
                        <td class="text-center"><span
                                class="badge bg-label-{{\Illuminate\Support\Facades\Config::get('tubuset.status_color')[$data->status]}} me-1">{{\Illuminate\Support\Facades\Config::get('tubuset.status')[$data->status]}}</span>
                        </td>
                        <td>
                            <button type="button" class="modals btn btn-sm btn-icon btn-outline-primary"
                                    data-href="{{route('panel.product.form',$data->_id)}}"
                            ><i class='bx bx-edit-alt'></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
