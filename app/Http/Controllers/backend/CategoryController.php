<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Seo;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $datas = [];
        $datas = Categories::orderBy('name')->get();
        return view('backend.category_list', ['datas' => $datas]);
    }

    public function form(Request $request, $id = 0) {
        $info = '';
        $json = [];
        if ($id == 0) {
            $info = new Categories();
            $data['action'] = route('panel.category.form');
            $json['title'] = 'Kategori Ekle';
        } else {
            $info = Categories::where('_id', '=',$id)->first();
            $data['action'] = route('panel.category.form', $id);
            $json['title'] = 'Kategori Güncelle';
        }

        if ($request->method() == 'POST') {
            if ($request->post('category') == 'üst') {
                $info->parent_id = 0;
            } else {
                $info->parent_id = $request->post('category');
            }

            $info->name = trim($request->post('category_name'));
            $info->status = $request->post('category_status') == 'on'?1:0;
            try {
                $info->save();
                Seo::addseo($info->_id, 'category',$info->name);
                if ($id) {
                    $json['success'] = $info->name.' güncellendi.';
                } else {
                    $json['success'] = $info->name.' eklendi.';
                }
                return redirect()->back();

            }catch (\Exception $e) {
                $json['error'] = 'BAŞARISIZ';
            }
        } else if ($request->method() == 'GET') {
            $json['success'] = true;
        }

        $json['html'] = view('backend.modal.category_form', ['info' => $info, 'data' => $data])->render();

        return $json;
    }
}
