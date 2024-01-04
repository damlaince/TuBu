@extends('backend.layouts.default')
@section('head')
    <title>Kategoriler</title>
@endsection
@section('content')
    <div class="card" id="app">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Ekleniş Tarihi</th>
                    <th>Kategori Türü</th>
                    <th>Kategori Adı</th>
                    <th>Durum</th>
                    <th>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-primary modals"
                                data-href="{{route('panel.category.form')}}"
                        >
                            <i class='bx bx-plus'></i>
                        </button>
                    </th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($datas as $data)
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                            <strong>{{$data->_id}}</strong></td>
                        <td>{{date("d.m.Y H:i",strtotime($data->created_at))}}</td>
                        <td>
                            @if($data->parent_id == 0)
                                Üst
                            @else
                                Alt
                            @endif
                        </td>
                        <td>{{$data->name}}</td>
                        <td><span class="badge bg-label-{{\Illuminate\Support\Facades\Config::get('tubuset.status_color')[$data->status]}} me-1">{{\Illuminate\Support\Facades\Config::get('tubuset.status')[$data->status]}}</span></td>
                        <td>
                            <button type="button" class="modals btn btn-sm btn-icon btn-outline-primary"
                                    data-href="{{route('panel.category.form',$data->_id)}}"
                                    ><i class='bx bx-edit-alt'></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
