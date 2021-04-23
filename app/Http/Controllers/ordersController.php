<?php

namespace App\Http\Controllers;

use App\orders;
use App\products;
use Illuminate\Http\Request;
use DB;


class ordersController extends Controller
{
    public function index(){
        $products = products::all();
        return view('orders/index',['products'=>$products]);
    }

    public function getPrice($id){
        $product = products::find($id);
        return response()->json(['price'=>$product->price,'price_format'=>number_format($product->price,2,',','.')], 200);
    }

    public function crearOrder(Request $request){
        try{
            DB::beginTransaction();
            $order = new orders();
            $order->customer_name = $request->customer_name;
            $order->customer_email = $request->customer_email;
            $order->customer_mobile = $request->customer_mobile;
            $order->product_id = $request->product_id;
            $order->amount = $request->amount;
            $order->ipAddress = \Request::ip();
            $order->status = "CREATED";
            $order->save();
            DB::commit();
            $message = "ORDEN DE COMPRA No. $order->id CREADO CON ÉXITO, DESEA IR AL CARRITO DE COMPRA ?";
            return $message;
        }catch (\Exception $e){
            DB::rollback();
            $message = $e->getMessage();
            return view('orders/error', compact('message'));
        }
    }

    public function list()
    {
        $requests = orders::where('payment_status','<>',NULL)
        ->orderBy('id','desc')->get();
        return view('orders/list', compact('requests'));
    }

    public function shoppingcart()
    {
        $requests = orders::where('status','CREATED')
        ->where('payment_status',NULL)
        ->with('product')->get();
        return view('orders/shoppingcart', compact('requests'));
    }


}
