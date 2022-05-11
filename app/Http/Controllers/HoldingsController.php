<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Tick;
use App\Models\Basket;
use Illuminate\Support\Facades\Auth;

class HoldingsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        if(request()->has('basket_id')){
            $basket_id = request()->basket_id;
        }else{
            $basket_id = 0;
        }
    //     $order = Order::pluck('token_id');
    //     $tick = Tick::get('properties');
    //     $tt = json_decode($tick,true);
    //     $td = $tt[0]['properties'];
        
    //     try{
    //     for($i = 0; $i < count($order); $i++){
    //         foreach($td as $data){
    //             foreach( $data as $var){
    //                 if($var['instrument_token'] == $order[$i]){
    //                  $results = Order::where('token_id','=',  $order[$i])
    //                     ->update(['ltp' => $var['last_price'] ]);

    //                 } 
    //             }
    //         }
    //     }
    // }catch(Exception $e){
    //     return response()->json('success',201);
    // }
    //     $holdings = Order::with('basket')->get();
        return view('holdings.index',compact('basket_id'));
    }

    // public function list(){
    //     return view('holdings.list');
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getHoldings()
     {
        $user = Auth::user();
        $user_id = $user->id;
        $order = Order::with('basket')->where('user_id', $user_id)->where('basket_id',request()->id)->where('status', 'Active')->get();
        foreach($order as $key=>$row) {
            $basket = Basket::find($row->basket_id);
            $order[$key]['basket_name'] = $basket->basket_name;
        }
        return response()->json(['order' => $order]);
     }
    public function getData()
    {

        
        // dd(request()->basket_id);
        // $ordered = Order::pluck('token_id');
        // $tick = Tick::get('properties');
        // $tt = json_decode($tick,true);
        // $td = $tt[0];
        // dd(request()->all());


    // for($i = 0; $i < count($ordered); $i++){
           //     foreach($td as $data){
           //         foreach( $data as $var){
           //             if($var['instrument_token'] == $ordered[$i]){
   
           //                 $results = Order::where('token_id','=',  $ordered[$i])->where('order_avg_price',null)
           //                     ->update([
           //                             'order_avg_price' => $var['last_price']
           //                     ]);
                           
           //                 // $ltp = Order::where('token_id', $order[$i])->first();
           //                    $results = Order::where('token_id','=',  $ordered[$i])
           //                     ->update([
           //                             'ltp' => $var['last_price']
           //                     ]);
           //             } 
           //         }
           //     }
           // }   
   // end new
   // $data->user_id = Auth::User()->id;
        
        $user = Auth::user();
        $user_id = $user->id;
        $orderdet = Order::with('basket')->where('user_id', $user_id)->where('status', 'Active');
        if(request()->basket_id != 0){
            $orderdet->where('basket_id',request()->basket_id);
        }
        $order = $orderdet->get();
        foreach($order as $key=>$row) {
            $basket = Basket::find($row->basket_id);
            $order[$key]['basket_name'] = $basket->basket_name;
        }
        return response()->json(['order' => $order]);        
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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