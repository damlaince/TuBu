<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Categories;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class ProductController extends Controller
{
    public function index($ustcategory, $altcategory = '')
    {

        $datas = [];

        if ($altcategory) {
            // seo tablosundan category idsini bul
            // product tablosunda bu idli ürünleri listele
            $id = Seo::categoryid($altcategory, 'category');

            $datas = Product::with('seo')->where('category_id', $id)->where('status', 1)->orderBy('created_at', 'ASC')->get();
        } else {
            $id = Seo::categoryid($ustcategory, 'category');
            $altcategoriesid = Categories::altcategories($id);
            $datas = Product::with('seo')->whereIn('category_id', $altcategoriesid)->where('status', 1)->orderBy('created_at', 'ASC')->get();
        }

        return view('frontend.product.products', ['datas' => $datas, 'ustcategory' => $ustcategory, 'altcategory' => $altcategory]);
    }

    public function detail(Request $request, $ustcategory, $altcategory = '', $product)
    {
        $cartDetail = '';
        try {
            $id = Seo::categoryid($product, 'product');
            $info = Product::with('seo')->where('_id', $id)->where('status', 1)->first();
        } catch (\Exception $e) {

        }

        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart && isset($cart['product'][$id])) {
            $cartDetail = $cart['product'][$id];
        }

        return view('frontend.product.product_detail', ['info' => $info, 'ustcategory' => $ustcategory, 'altcategory' => $altcategory, 'cartDetail' => $cartDetail]);
    }

    public function cartSave(Request $request, $ustcategory, $altcategory = '', $id)
    {

        $json = [];
        // ürün var mı?
        // ürünün stok sayısı istenilen ürün sayısıyla tutuyor mu?

        if ((int)$request->post('custom') == 0) {
            $json['error'] = 'Sepete en az 1 ürün ekleyebilirsiniz.';
            return $json;
        }
        if (!$request->post('size')) {
            $json['error'] = 'Beden Seçmelisiniz.';
            return $json;
        }

        try {
            $product = Product::where('_id', $id)->where('status', 1)->first();
        } catch (Exception $e) {
            $json['error'] = 'Ürün Bulunamadı!';
        }
        if ((int)$product->custom >= (int)$request->post('custom')) {
            // user_id, product altında (product id, price, custom), total_price
            //

            $cart = Cart::where('user_id', $request->post('user'))->first();

            if (!$cart) {
                $cart = new Cart();
                $cart->total_price = 0;
            } else {
                if (isset($cart['product'][$product->_id]['total_price'])) {
                    $cart->total_price -= $cart['product'][$product->_id]['total_price'];
                }
            }
           $newcopy = [];

            $cart->user_id = $request->post('user');
            $cart->total_price += (int)$request->post('custom') * (int)@$product->price;

            $newcart = [
                'product_id' => $id,
                'custom' => (int)$request->post('custom'),
                'size' => $request->post('size'),
                'price' =>  (int)@$product->price,
                'total_price' => (int)$request->post('custom') * (int)@$product->price
            ];

            $cartcopy = $cart->product;

            if(!is_array($cartcopy)) {
                $cartcopy = [];
            }
            $cartcopy[$id] = $newcart;

            $cart->product = $cartcopy;

            try {
                $cart->save();
                $json['success'] = true;
            } catch (Exception $e) {
                $json['error'] = 'Hata!!';
            }

        } else {
            $json['error'] = 'Üründen ' . (int)$product->custom . ' adet bulunuyor.';
        }

        return $json;
    }

}
