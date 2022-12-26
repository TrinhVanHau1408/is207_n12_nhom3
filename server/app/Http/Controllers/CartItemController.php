<?php

namespace App\Http\Controllers;


use App\Models\CartItem;
use App\Models\Phone;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cartItem = CartItem::All();

        return response()->json($cartItem);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'item'
        ]);
 
        $customerId = $request->json('customerId');
        $item =  $request->json('item');
        $phoneId = $item['phoneId'];
        $imgUrl = $item['imgUrl'];
        $phoneDetailId = $item['phoneDetailId'];
        $quantity = $item['quantity'];
        $priceSale = $item['priceSale'];

        $phone = Phone::find($phoneId);
        $cartItem = CartItem::where("customerId", $customerId )->where("phoneDetailId",  $phoneDetailId)->first();
       
        // Kiểm tra CartItem đã có chưa
        // / -> Nếu chưa thì tạo mới một CartItem
        // / -> Nếu có thì cập nhật quantity
        if (!$cartItem) {
            $cartItem = CartItem::create([
                "customerId" => $customerId,
                "imgUrl" => $imgUrl,
                "phoneName" => $phone->name,
                "phoneDetailId" => $phoneDetailId,
                "quantity" => $quantity,
                "priceSale" => $priceSale,
                "totalMoney" => $quantity *$priceSale
            ]);
        } else {

            $cartItem->quantity = $cartItem->quantity + $quantity;
            $cartItem->priceSale = $priceSale;
            $cartItem->totalMoney = $cartItem->quantity * $priceSale;

            $cartItem->save();
        }
      
        return [
            "status" => 1,
            "data" =>  $cartItem,
            "msg" => "Cart item store successfully"
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
        $cartItem = CartItem::where("customerId", "=", $id)->get();
        return [
            "status" => 1,
            "cart" =>$cartItem
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            "customerId",
            "item",
           
        ]);

        // $customerId = $request->json('customerId');
        $item =  $request->json('item');
        // $phoneId = $item['phoneId'];
        // $phoneDetailId = $item['phoneDetailId'];
        $id = $item['id'];
        $quantity = $item['quantity'];
        $priceSale = $item['priceSale'];

        $cartItem = CartItem::find($id);
        if ($quantity<=0) {
            $cartItem->forceDelete();
        } else {

            $cartItem->quantity = $quantity;
            $cartItem->priceSale = $priceSale;
            $cartItem->totalMoney = $cartItem->quantity * $priceSale;
            $cartItem->save();
        }

        return [
            "status" => 1,
            "data" =>$cartItem,
            "msg" => "Cart item update successfully"
        ];
 
    }

     /**
     * Soft Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $cartItem = CartItem::find($id)->forceDelete();

        return [
            "status" => 1,
            "data" =>  $cartItem,
            "msg" => "Cart item delete successfully"
        ];
    }

    //  /**
    //  * Restore one the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function restore($id)
    // {
    //     CartItem::withTrashed()->find($id)->restore();

    //     return [
    //         "status" => 1,
    //         "msg" => "Restore one successfully"
    //     ];
    // }

    //  /**
    //  * Restore one the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function restoreAll()
    // {
    //     CartItem::onlyTrashed()->restore();

    //     return [
    //         "status" => 1,
    //         "msg" => "Restore all successfully"
    //     ];
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
