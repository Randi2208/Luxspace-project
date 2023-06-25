<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChechkoutRequest;
use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class FrontendController extends Controller
{
    public function index(Request $request){

        //mengambil data products dengan galleries
        $products = Product::with(['galleries'])->latest()->get();

        return view('pages.frontend.index',compact("products"));
    }

    public function details(Request $request,$slug){
        //mengambil data product dengan galleris dimana slug nya belupa variabel slug klo ada di data base akan ditampilkan klo tak ada akan eror
        $product = Product::with(['galleries'])->where('slug', $slug)->firstOrFail();
        
        //MENGAMBIL DATA PRODUCT SECARA RANDOM
        $recommendations = Product::with(['galleries'])->inRandomOrder()->limit(4)->get();
        return view('pages.frontend.details',compact('product','recommendations'));
    }

    public function cartDelete(Request $request,$id){
        //mengambil data item yang ingin dihapus 
        $item =  Cart::findOrFail($id);
        $item->delete();
        return redirect('cart');

    }
    public function cartAdd(Request $request,$id){
        Cart::create([
            'users_id'=>Auth::user()->id ,
            'products_id' =>$id
        ]);
        
        return redirect('cart');
    }
    public function cart(Request $request){
        //mendapatkan data cart dimana user_id nya yaitu user id yang sekarang 
        $carts = Cart::with(['product.galleries'])->where('users_id',Auth::user()->id)->get();
        return view('pages.frontend.cart',compact('carts'));
    }
    public function checkout(CheckoutRequest $request){
        //mengambil semua data dari request
        $data = $request->all();

        //mengambil data cart dimana user id nya adalah user id yang login saat ini
        $carts = Cart::with(['product'])->where('users_id',Auth::user()->id)->get();

        //menambah ke data transaksi
        $data['users_id'] = Auth::user()->id;
        $data['total_price'] = $carts->sum('product.price');

        //membuat transaction
        $transaction = Transaction::create($data);

        //membuat transaksi item
        foreach ($carts as $cart) {
            $items[]=TransactionItem::create([
                'transactions_id' =>$transaction->id,
                'users_id'=>$cart->users_id,
                'products_id'=>$cart->products_id
            ]);
        }

        //meghapusdata cart setelah transactions
        Cart::where('users_id',Auth::user()->id)->delete();
        
        //configurasi dengan midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds= config('services.midtrans.is3ds');

        //membuat setup midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id'=>'LUX-' .$transaction->id,
                'gross_amount'=>(int)$transaction->total_price,
            ],
            'customer_details'=>[
                'first_name'=>$transaction->name,
                'email'=>$transaction->email
            ],
            'enable_payments' =>['gopay','bank_transfer'],
            'vtweb' => []
        ];

        //membuat try catch
        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
            
            $transaction->payment_url = $paymentUrl;
            $transaction->save();

            //redirect ke pepembayaran
            return redirect($paymentUrl);
          
          }
          catch (Exception $e) {
            echo $e->getMessage();
          }
    }
    public function success(Request $request){
        return view('pages.frontend.success');
    }
}
