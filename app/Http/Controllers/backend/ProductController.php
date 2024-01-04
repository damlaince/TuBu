<?php

namespace App\Http\Controllers\backend;

use App\Helper\tubuHelper;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Product;
use App\Models\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $datas = [];
        $datas = Product::with(['category'])->orderBy('title', 'ASC')->get();

        return view('backend.product_list', ['datas' => $datas]);
    }

    public function form(Request $request, $id = 0)
    {

        $data = $json = [];
        $info = '';

        if ($id == 0) {
            $info = new Product();
            $json['title'] = 'Ürün Ekle';
            $data['action'] = route('panel.product.form');
        } else {
            $info = Product::with(['category'])->where('_id', $id)->first();
            $json['title'] = 'Ürün Güncelle';
            $data['action'] = route('panel.product.form', $id);
        }

        if ($request->method() == 'POST') {

            /*$validate = \Illuminate\Support\Facades\Validator::make($request->all(),
                [
                 'category_id' => 'required',
                 'name' => 'required|min:3|max:255',
                 'sizes' => 'required'
                ],
                [
                    'category_id.required' => 'Kategori girmek zorunludur.',
                    'name.required' => 'Ürün adı girmek zorunludur.',
                    'name.min' => 'Ürün adı en az 3 karakter içermelidir.',
                    'name.max' => 'Ürün adı en çok 255 karakter içermelidir',
                    'sizes.required' => 'Ürün bedeni girmek zorunludur.'
                ]
            );*/

            $info->category_id = $request->post('category_id');
            $info->name = $request->post('name');
            $info->color = $request->post('color');
            $info->custom = $request->post('custom');
            $info->price = $request->post('price');
            $info->gender = $request->post('gender');
            $info->status = $request->post('status') == 'on' ? 1 : 0;
            $info->description = $request->post('description');

            if (isset($request->post('sizes')[0]) && $request->post('sizes')[0] == 'all') {
                $info->sizes = Config::get('tubuset.sizes');
            } else {
                $info->sizes = $request->post('sizes');
            }

            if ($request->file('product_images')) {
                foreach ($request->file('product_images') as $key => $file) {
                    $fileName = tubuHelper::seoreplacer($request->post('name')) . '_' . rand(0, 1000) . '.' . $file->extension();
                    $path = 'products';

                    $file->storeAs('public/' . $path, $fileName);
                    $file->move(public_path('products'), $fileName);

                    $files[] = $path . '/' . $fileName;
                }

                $info->images = $files;
            }

            try {
                $info->save();
                Seo::addseo($info->_id, 'product',$info->name);
                return redirect()->back();
            } catch (\Exception $e) {
                $json['error'] = 'BAŞARISIZ';
            }
        } else {
            $json['success'] = true;
        }

        $json['html'] = view('backend.modal.product_form', ['data' => $data, 'info' => $info])->render();

        return $json;
    }
}
