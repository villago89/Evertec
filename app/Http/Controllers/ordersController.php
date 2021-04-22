<?php

namespace App\Http\Controllers;

use App\orders;
use App\products;
use Illuminate\Http\Request;

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
        var_dump(23);
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
        $reference = $order->id;
        DB::commit();
        return view('orders/shoppingcart', compact('requests'));
    }

    public function list()
    {
        //$qb = orders::where('status','<>','CREATED')->orderBy('id','desc')->get();
        $qb = orders::orderBy('id','desc')->get();
        $requests = $qb;
        return view('orders/list', compact('requests'));
    }

    public function shoppingcart()
    {
        $qb = orders::where('status','CREATED')->with('product')->get();
        $requests = $qb;
        return view('orders/shoppingcart', compact('requests'));
    }


}
