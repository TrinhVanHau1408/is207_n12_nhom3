<?php

namespace App\Http\Controllers;
use App\Models\Phone;
use App\Models\PhoneDetail;
use Illuminate\Http\Request;


class PhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $phones = Phone::All();

        return response()->json($phones);
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
            'name',
            'categoryId',
            'imgUrl',
            'quantity',
            'priceSale',
            'description',
            'variants',
            'sim',
            'screen',
            'camera',
        ]);

        $phoneData = $request->json('data');
        // if (!Phone::where('name', $phoneData['name'] )) {
        //     return [
        //         "status" => 0,
        //         "msg" => "Insert phone failure, ". $phoneData['name'] ." already exist!"
        //     ];
        // };

        $phone = Phone::insert([
            'name' => $phoneData['name'],
            'categoryId' => $phoneData['categoryId'],
            'imgUrl' => $phoneData['imgUrl'],
            'quantity' => $phoneData['quantity'],
            'priceSale' => $phoneData['priceSale'],
            'description' => $phoneData['description'],
            'sim' => $phoneData['sim'],
            'screen' => $phoneData['screen'],
            'camera'=> $phoneData['camera'],
            'ratingStart' => 0,
            'viewCustomer' =>0
        ]);

        $phoneCurrId = Phone::max('id');
        $variants = $phoneData['variants'];
        if(!empty($variants)) {
            foreach ($variants as $key => $variant) {
                PhoneDetail::insert([
                    'phoneId' =>  $phoneCurrId,
                    'ramId' =>  $variant['ramId'],
                    'romId' => $variant['romId'],
                    'colorId' => $variant['colorId'],
                    'quantity' => $variant['quantity'],
                    'percentPrice' => $variant['percentPrice']
                ]);
            };
        };

        return [
            "status" => 1,
            "data" => $phoneCurrId,

        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $phone = Phone::where('slug', '=', $slug)->first();
        $phoneVariant = PhoneDetail::where('phoneId', '=',$phone->id)
        ->leftJoin('ram', 'ram.id' ,'=', 'phone_detail.ramId')
        ->leftJoin('rom', 'rom.id' ,'=', 'phone_detail.romId')
        ->leftJoin('color', 'color.id' ,'=', 'phone_detail.colorId')
        ->select('phone_detail.*', 'ram.name as ram', 'rom.name as rom', 'color.name as color','quantity','percentPrice')
        ->whereNull('phone_detail.deleted_at')
        ->whereNull('ram.deleted_at')
        ->whereNull('rom.deleted_at')
        ->whereNull('color.deleted_at')
        ->get();
        return response()->json(['phone' =>$phone, 'variants' => $phoneVariant]);
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

     /*Sẽ build tiếp khi có giao diện */
    public function update(Request $request, $id)
    {
       
       
        $request->validate([
            'name',
            'categoryId',
            'imgUrl',
            'quantity',
            'priceSale',
            'description',
            'variants',
            'sim',
            'screen',
            'camera',
        ]);

        $phoneData = $request->json('data');

        $phone = Phone::find($id);

        $phone->name = $phoneData['name'];
        $phone->categoryId = $phoneData['categoryId'];
        $phone->imgUrl = $phoneData['imgUrl'];
        $phone->quantity = $phoneData['quantity'];
        $phone->priceSale = $phoneData['priceSale'];
        $phone->description = $phoneData['description'];
        $phone->sim = $phoneData['sim'];
        $phone->screen = $phoneData['screen'];
        $phone->camera = $phoneData['camera'];

        $phone->save();



        /*Update Variants =>[phoneDetailId, ramId, romId, colorId, percentPrice]
        
        /*Update biến thể sản phẩm */
        foreach ($phoneData['variants'] as $key => $variant) {
            $phoneDetailId=(int)$variant['phoneDetailId'];
            $phoneDetail=PhoneDetail::find($phoneDetailId);
            $phoneDetail->ramId = (int)$variant['ramId'];
            $phoneDetail->romId = (int)$variant['romId'];
            $phoneDetail->colorId = (int)$variant['colorId'];
            $phoneDetail->percentPrice = (int)$variant['percentPrice'];
            $phoneDetail->save();
        }
          

        // }
        // $str = $request->array;
        // $arr = explode(';', $str);
        // foreach ( $arr as $key => $value) {
        //     $a= explode(',',$value);
        //     foreach ( $a as $k => $v) {
        //        $variant = PhoneDetail::where('id', $id);
        //     }

        // };



        return [
            "status" => 1,
            "msg" => "Blog updated successfully"
        ];
    }

     /**
     * Search anything field resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // $phone = Phone::find($id)->delete();
        // $request->validate(['search']);

        $search = $request->search;
       
        // $phone=Phone::select('phone.*')
        //     ->leftJoin('phone_detail', 'phone_detail.phoneId', '=', 'phone.id')
        //     ->orWhere('phone.name','LIKE','%'.$search.'%')
        //     ->orWhere('description','LIKE','%'.$search.'%')
        //     ->leftJoin('ram', 'ram.id', '=', 'phone_detail.ramId')
        //     ->leftJoin('rom', 'rom.id', '=', 'phone_detail.romId')
        //     ->leftJoin('color', 'color.id', '=', 'phone_detail.colorId')
        //     ->orWhere('color.name','LIKE','%'.$search.'%')
        //     ->orWhere('ram.name','LIKE','%'.$search.'%')
        //     ->orWhere('rom.name','LIKE','%'.$search.'%')
        //     ->distinct()
        //     ->get();

        $phone=Phone::where('name','LIKE','%'.$search.'%')->get();

        if ($phone->count()==0) return [
            "status" => 0,
            "msg" => "Search does not exist"
        ];

        return [
            "status" => 1,
            'data' =>$phone ,
            "msg" => "Search anything successfully"
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
        $phone = Phone::find($id)->delete();

        return [
            "status" => 1,
            "data" =>  $phone,
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
        Phone::withTrashed()->find($id)->restore();

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
        Phone::onlyTrashed()->restore();

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
