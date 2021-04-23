<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\orders;
use App\products;
use DB;
use GuzzleHttp\RetryMiddleware;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use PhpParser\Node\Expr\Print_;

class placetopayController extends Controller
{
    

    public function crearTransaccion($reference){   
        try{
            $order = orders::where('id',$reference)->first();
            DB::beginTransaction();
            $login = \Config::get('placetopay.P2P_LOGIN');
            $tranKey = \Config::get('placetopay.P2P_TRANKEY');
            $endPoint = \Config::get('placetopay.P2P_ENDPOINT');

            $placetopay = new \Dnetix\Redirection\PlacetoPay([
                'login' => $login ,
                'tranKey' => $tranKey,
                'url' => $endPoint,
            ]);

            $request_placetopay = [
                'locale' => 'es_CO',
                'buyer' => [
                    'name' => $order->customer_name,
                    'email' => $order->customer_email,
                    'documentType' => 'CC',
                    'document' => '1848839248',
                    'mobile' => $order->customer_mobile,
                    'address' => [
                        'street' => '703 Dicki Island Apt. 609',
                        'city' => 'North Randallstad',
                        'state' => 'Antioquia',
                        'postalCode' => '46292',
                        'country' => 'CO',
                        'phone' => '363-547-1441 x383',
                    ],
                ],
                'payment' => [
                    'reference' => $reference,
                    'description' => 'COMPRA No.'.$reference,
                    'amount' => [
                        'currency' => 'COP',
                        'total' => $order->amount,
                    ],
                ],
                'expiration' => date('c', strtotime('+2 days')),
                'returnUrl'  => url('confirmacion') . '/'.$reference ,
                'cancelUrl'  => url('confirmacion') . '/' . $reference,
                'ipAddress' => \Request::ip(),
                'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
                //'skipResult' => true,
            ];

            $response = $placetopay->request($request_placetopay);
            if ($response->isSuccessful()) {
                $order->requestId = $response->requestId();
                $order->payment_status = $response->status()->status();
                $order->payment_reason = $response->status()->reason();
                $order->payment_message = $response->status()->message();
                $order->payment_date = $response->status()->date();
                $order->update();
                $processUrl = $response->processUrl();
                DB::commit();
                return view('orders/pagos', compact('processUrl'));
            } else {
                DB::rollback();
                $message = $response->status()->message();
                return view('orders/error', compact('message'));
            }
        }catch (\Exception $e){
                DB::rollback();
                $message = $e->getMessage();
                return view('orders/error', compact('message'));
        }
    }

    public function confirmacion($requestId){   
        try{
            $order = orders::where('id',$requestId)->first();
            $login = \Config::get('placetopay.P2P_LOGIN');
            $tranKey = \Config::get('placetopay.P2P_TRANKEY');
            $endPoint = \Config::get('placetopay.P2P_ENDPOINT');
   
          
            $placetopay = new \Dnetix\Redirection\PlacetoPay([
                'login' => $login ,
                'tranKey' => $tranKey,
                'url' => $endPoint,
            ]);
            
            $response = $placetopay->query($order->requestId);
            if(isset($response->toArray()['payment'][0]['status'])){
                $payment = $response->toArray()['payment'][0]['status'];
                $order->payment_status = $payment['status'];
                $order->payment_reason = $payment['reason'];
                $order->payment_message = $payment['message'];
                $order->payment_date = $payment['date'];
                $order->payment_reference = $response->toArray()['payment'][0]['reference'];
                $order->payment_authorization = $response->toArray()['payment'][0]['authorization'];
            }else{
                $payment = $response->toArray()['status'];
                $order->payment_status = $payment['status'];
                $order->payment_reason = $payment['reason'];
                $order->payment_message = $payment['message'];
                $order->payment_date = $payment['date'];
            }
            if($payment['status'] == 'APPROVED'){
                $order->status = 'PAYED';
            }else{
                $order->status = 'REJECTED';
            }
            $order->update();
            
            if (!$response->isSuccessful()) {
                print_r($response->status()->message() . "\n");
            }
            return view('orders/pagos-confirmacion', compact('order'));
        }catch (\Exception $e){
                $message = $e->getMessage();
                return view('orders/error', compact('message'));
        }
    }
}
