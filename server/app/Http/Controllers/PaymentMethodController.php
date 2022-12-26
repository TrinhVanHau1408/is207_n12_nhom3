<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = PaymentMethod::All();

        return response()->json($payments);
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
            'name'
        ]);
 
        $payment = PaymentMethod::create($request->json()->all());
      
        return [
            "status" => 1,
            "data" => $payment
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
        $payment = PaymentMethod::find($id);
        return [
            "status" => 1,
            "data" =>$payment
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'
        ]);

        $payment = PaymentMethod::find($id);

        $payment->name = $request->json("name");

        $payment->save();

        return [
            "status" => 1,
            "data" =>$payment
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
        $payment = PaymentMethod::find($id)->delete();

        return [
            "status" => 1,
            "data" =>  $payment,
            "msg" => "Phone soft delete successfully"
        ];
    }

     /**
     * Restore one the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        PaymentMethod::withTrashed()->find($id)->restore();

        return [
            "status" => 1,
            "msg" => "Restore one successfully"
        ];
    }

     /**
     * Restore one the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restoreAll()
    {
        PaymentMethod::onlyTrashed()->restore();

        return [
            "status" => 1,
            "msg" => "Restore all successfully"
        ];
    }

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
