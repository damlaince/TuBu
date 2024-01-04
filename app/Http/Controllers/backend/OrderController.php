<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        $datas = [];
        $datas = Order::with(['user'])->orderBy('status')->get();

        return view('backend.order_list', ['datas' => $datas]);
    }

    public function detail(Request $request, $id) {

        $data['action'] = route('panel.order.detail', $id);

        $info = Order::with(['user'])->where('_id', $id)->first();

        if ($request->method() == 'POST') {
            $info->status = $request->post('status');
            $info->save();
            return redirect()->back();
        }

        $json['success'] = true;
        $json['html'] = view('backend.modal.order_detail', ['data' => $data, 'info' => $info])->render();
        return $json;
    }
}
