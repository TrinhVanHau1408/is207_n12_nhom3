<?php

namespace App\Http\Controllers;

use App\Models\PhoneDetail;
use Illuminate\Http\Request;

class PhoneDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phoneDetails = PhoneDetail::All();

        return response()->json($phoneDetails);
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
            'phoneId' => 'require',
            'ramId' => 'require',
            'romId' => 'require',
            'colorId' => 'require',
            'percentPrice' => 'require',
        ]);
 
        $phoneDetail = PhoneDetail::create($request->json()->all());
      
        return [
            "status" => 1,
            "data" => $phoneDetail
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
        $phoneDetail = PhoneDetail::find($id);
        return [
            "status" => 1,
            "data" =>$phoneDetail
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
            'phoneId' => 'require',
            'ramId' => 'require',
            'romId' => 'require',
            'colorId' => 'require',
            'percentPrice' => 'require',
        ]);
        $phoneDetail = PhoneDetail::find($id);

        $phoneDetail->phoneId = $request->json('phoneId');
        $phoneDetail->ramId = $request->json('ramId');
        $phoneDetail->romId = $request->json('romId');
        $phoneDetail->colorId = $request->json('colorId');
        $phoneDetail->percentPrice = $request->json('percentPrice');

        $phoneDetail->save();

        return [
            "status" => 1,
            "data" =>$phoneDetail
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
        $phoneDetail = PhoneDetail::find($id)->delete();

        return [
            "status" => 1,
            "data" =>  $phoneDetail,
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
        PhoneDetail::withTrashed()->find($id)->restore();

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
        PhoneDetail::onlyTrashed()->restore();

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
