<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use PharIo\Manifest\Author;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $datacart = $datas = [];
        $datacart = Cart::where('user_id', Auth::id())->first();
        if ($datacart) {
            foreach ($datacart['product'] as $key => $cart) {
                if ($cart) {
                    $product = Product::where('status', 1)->where('_id', $cart['product_id'])->first();

                    $datas['product'][] = [
                        'product_id' => $cart['product_id'],
                        'custom' => $cart['custom'],
                        'size' => $cart['size'],
                        'price' => $cart['price'],
                        'total_price' => $cart['total_price'],
                        'name' => $product['name'],
                        'image' => $product['images'][0]
                    ];
                }

            }
        }

        if ($request->method() == 'POST') {
            if ($request->post('update') == 'cart') {
                $datacart->total_price = 0;
                foreach ($request->post('num-product') as $key => $custom) {
                    Cart::where('user_id', Auth::id())->update([
                        "product.$key" => [
                            'product_id' => $datacart['product'][$key]['product_id'],
                            'size' => $datacart['product'][$key]['size'],
                            'custom' => (int)$custom,
                            'price' => $datacart['product'][$key]['price'],
                            'total_price' => $datacart['product'][$key]['price'] * (int)$custom
                        ],
                    ]);
                    $datacart->total_price += $datacart['product'][$key]['price'] * (int)$custom;
                }
            } else if ($request->post('delete')) {
                $datacart->total_price -= $datacart['product'][$request->post('delete')]['total_price'];
                Cart::where('user_id', Auth::id())->update([
                    "product." . $request->post('delete') => null
                ]);

            } else if ($request->post('update') == 'adress') {
                $adress = $datacart->adress;

                if (!is_array($adress)) {
                    $adress = [];
                }

                $adress['country'] = Config::get('tubuset.country')[$request->post('country')];
                $adress['state'] = $request->post('state');
                $adress['street'] = $request->post('street');
                $adress['no'] = $request->post('no');
                $adress['postcode'] = $request->post('postcode');

                $datacart->adress = $adress;
            }

            $datacart->save();
            return redirect()->back();
        }

        if ($datacart) {
            $datas['total'] = $datacart['total_price'];

            if ($datacart->total_price == 0) {
                Cart::where('user_id', Auth::id())->delete();
            }
        }


        return view('frontend.order.cart', ['datas' => $datas, 'datacart' => $datacart]);
    }

    public function payment(Request $request)
    {

        // ödeme bilgilerini al
        // ödeme bilgileriyle beraber kullanıcının sepetteki ürünlerini order tablosuna geçir.
        // ödeme bilgileri bir array içerisine

        if ($request->method() == 'POST') {
            $cart = Cart::where('user_id', Auth::id())->first();
            $cart = $cart->toArray();
            $order = new Order($cart);


            $payment = [
                'fullname' => $request->post('fullname'),
                'card_no' => $request->post('cardNumber'),
                'date_y' => $request->post('date_y'),
                'date_m' => $request->post('date_m'),
                'cvv' => $request->post('cvv')
            ];

            $paymentcopy = $order->payment;

            if (!is_array($paymentcopy)) {
                $paymentcopy = [];
            }

            $paymentcopy = $payment;
            $order->payment = $paymentcopy;
            $order->status = 0;
            $order->code = strtoupper(substr(md5(rand(0, 90)), 0, 8));
            $order->save();

            DB::table('cart')->where('user_id', Auth::id())->delete();

            return redirect()->route('front.home');
        }
        return view('frontend.order.payment');
    }

    public function list() {
        $datas = [];
        $datas = Order::where('user_id', Auth::id())->orderBy('created_at', 'ASC')->get();

        return view('frontend.order.list',['datas' => $datas]);
    }
}
