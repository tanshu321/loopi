<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        return response()->json($orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Order::create([
            'customer_id' => rand(1, 10000),
            'created_at' => date('Y-m-d H:m:i', strtotime('now')),
            'updated_at' => date('Y-m-d H:m:i', strtotime('now')),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Order $order)
    {
        $order = Order::find($id);
        $product_id = $request->get('product_id');

        if (!$order || empty($product_id)) {
            return response()->json(
                [
                    'message' => 'Order or Product not found',
                ],
                201
            );
        }

        $product = Product::find($product_id);

        if (!$product) {
            return response()->json(
                [
                    'message' => 'No Product found for this product id',
                ],
                201
            );
        }
        /*if(empty($product_id)){
            return response()->json([
                'hello' => $value
            ], 201)
        }*/

        OrderProduct::create([
            'order_id' => $id,
            'product_id' => $product_id,
            'price' => $product->price,
        ]);

        $order->total += $product->price;
        $order->save();

        return response()->json(
            [
                'message' => 'Order updated successfully',
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function payorder($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(
                [
                    'message' => 'Order not found',
                ],
                201
            );
        }

        $customer = Customer::find($order->customer_id);
        if (!$customer) {
            return response()->json(
                [
                    'message' => 'Customer not found',
                ],
                201
            );
        }

        $postdata = [
            'order_id' => $id,
            'customer_email' => $customer->email_address,
            'value' => $order->total,
        ];
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://superpay.view.agentur-loop.com/pay',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postdata),
            CURLOPT_HTTPHEADER => [
                'cache-control: no-cache',
                'content-type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return response()->json(
                [
                    'message' => $err,
                ],
                201
            );
        } else {
            $order->status = 1;
            $order->save();

            return response()->json(
                [
                    'message' => 'Payment Successful',
                ],
                200
            );
        }
    }
}
