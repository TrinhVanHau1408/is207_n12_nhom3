<?php

namespace App\Http\Controllers;

use App\Models\AddressReceive;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\PhoneDetail;
use App\Models\ShipMethod;
use App\Models\Status as ModelsStatus;
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

        $orderDetail = [];
        foreach ($orders as $key => $order) {
            $orderId = $order->id;
            $paymentId = $order->paymentId;
            $shipId = $order->shipId;
            $addressReceiveId = $order->addressReceiveId;
            $statusId = $order->statusId;

            $orderItem = OrderItem::where("orderId", "=", $orderId)->get();
            $payment = PaymentMethod::where("id", "=",  $paymentId)->select("id", "name")->first();
            $ship = ShipMethod::where("id", "=", $shipId)->select("id", "name", "feePrice as free")->first();
            $addressReceive = AddressReceive::where("id", "=", $addressReceiveId)->select("id", "nameReceiver", "numberPhoneReceiver", "addressReceiver", "numberApartment", "defaultAddress")->first();
            $status = ModelsStatus::where("id", "=", $statusId)->select("id", "name")->first();

            $orderDetail[$key] = [
                "order" =>$order,
                "detail" => [
                    "payment" => $payment,
                    "ship" => $ship,
                    "addressReceiveId" => $addressReceive,
                    "status" => $status,
                    "item" => $orderItem
                ]
            ];
        }
        return [
            "status" => 1,
            "data" => $orderDetail
        ];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customerId',
            'paymentId',
            'shipId',
            'addressReceiveId',
            'statusId',
            'cartItemId',
            'noteMess'
        ]);
 
        $customerId = $request->json('customerId');
        $cartItemId = $request->json('cartItemId');
        $paymentId = $request->json('paymentId');
        $shipId = $request->json('shipId');
        $addressReceiveId = $request->json('addressReceiveId');
        $statusId = $request->json('statusId');
        $noteMess = $request->json('noteMess');
       
        $orderCode = substr(md5(time()), 0, 16);


        $order = Order::create([
            'customerId' => $customerId,
            'orderCode' => $orderCode,
            'paymentId' => $paymentId,
            'shipId' => $shipId,
            'addressReceiveId'=> $addressReceiveId,
            'statusId' => $statusId,
            'noteMess' => $noteMess
        ]);

        $orderId = $order->id;
     
        // Lưu Cart Item
        foreach ($cartItemId as $key => $itemId) {
        
           $cartItem = CartItem::find($itemId);
           $imgUrl = $cartItem->imgUrl;
           $phoneName = $cartItem->phoneName;
           $phoneDetailId = $cartItem->phoneDetailId;
           $priceSale = $cartItem->priceSale;
           $quantity = $cartItem->quantity;
           $totalMoney = $cartItem->totalMoney;

           /// Thêm vào order item
            OrderItem::create([
                "orderId" => $orderId,
                "imgUrl" =>  $imgUrl,
                "phoneName" => $phoneName,
                "phoneDetailId" => $phoneDetailId,
                "priceSale" => $priceSale,
                "quantity" => $quantity,
                "totalMoney" => $totalMoney
            ]);

            // Sau khi thêm vào order item thì cập nhật lại số lượng hiện có của sản phẩm

            $phoneDetail = PhoneDetail::find($phoneDetailId);
            $phoneDetail->quantity -= $quantity;
            $phoneDetail->save();
    
            // Xóa trong cart item của sản phẩm đó.
            $cartItem->forceDelete();
        };
      
        return [
            "status" => 1,
            "data" => ["order" => $order]
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $order = Order::find($id);
        // $order = Order::where('customerId','=', $id)->first();

        // $orderId = $order->id;
        // $paymentId = $order->paymentId;
        // $shipId = $order->shipId;
        // $addressReceiveId = $order->addressReceiveId;
        // $statusId = $order->statusId;

        $orderItem = OrderItem::join('order', 'order.id', '=', 'order_item.orderId')
        ->where('customerId','=', $id)
        ->get();
        // $payment = PaymentMethod::where("id", "=",  $paymentId)->select("id", "name")->first();
        // $ship = ShipMethod::where("id", "=", $shipId)->select("id", "name", 'feePrice as free')->first();
        // $addresReceive = AddressReceive::where("id", "=", $addressReceiveId)->select("id", "nameReceiver", "numberPhoneReceiver", "addressReceiver", "numberApartment", "defaultAddress")->first();
        // $status = ModelsStatus::where("id", "=", $statusId)->select("id", "name")->first();
        
        // return [
        //     "status" => 1,
        //     "data" => [
        //         "order" =>$order,
        //         "detail" => [
        //             "payment" => $payment,
        //             "ship" => $ship,
        //             "addresReceive" =>  $addresReceive,
        //             "status" => $status,
        //             "item" => $orderItem
        //         ]
        //     ]
        // ];

        return [
            "status" => 1,
            "data" => $orderItem
            
        ];
        
        // return ["satus"=> $order];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'addressReceiveId',
            'noteMess'
        ]);

        $addressReceiveId = $request->json('addressReceiveId');
        $noteMess = $request->json('noteMess');

        $order = Order::find($id);

        $order->addressReceiveId =  $addressReceiveId;
        $order->noteMess =  $noteMess;

        $order->save();

        return [
            "status" => 1,
            "data" =>$order
        ];
 
    }

     /**
     * ~Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Tìm order cần xóa
        $orderItems = OrderItem::where("orderId", "=", $id)->get();

        foreach ($orderItems as $key => $orderItem) {
            $phoneDetailId = $orderItem->phoneDetailId;
            $quantity = $orderItem->quantity;

            // Cập nhật lại số lượng khi xóa order item
            $phoneDetail = PhoneDetail::find($phoneDetailId);
            $phoneDetail->quantity += $quantity;

            $phoneDetail->save();

            // Xóa order item
            $orderItem->forceDelete();
        }
        
        // Xóa order
        Order::find($id)->forceDelete();


        return [
            "status" => 1,
            "msg" => "Order delete successfully"
        ];
    }

   
}
