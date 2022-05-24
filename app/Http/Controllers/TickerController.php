<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Tick;
use App\Models\Order;
use App\Models\Basket;
use Illuminate\Http\Request;
use KiteConnect\KiteConnect;

class TickerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exist = Tick::get();
        return response()->json($exist);
         /*$kite = new KiteConnect("t8e53owre5vhtme0", "eoyEtgl10m9U50wa4P2QRkvcawuZrqVi");
     
        try {
            $user = $kite->generateSession("t8e53owre5vhtme0", "eoyEtgl10m9U50wa4P2QRkvcawuZrqVi");
            echo "Authentication successful. \n";
            print_r($user);
            $kite->setAccessToken($user->access_token);
        } catch(Exception $e) {
            echo "Authentication failed: ".$e->getMessage();
            throw $e;
        }
    
        echo $user->user_id." has logged in";*/

   /*     $data = [{'tradable': True, 'mode': 'full', 
            'instrument_token': 10603522, 'last_price': 273.1, 'last_traded_quantity': 50, 'average_traded_price': 286.71,
             'volume_traded': 241000, 'total_buy_quantity': 79150, 'total_sell_quantity': 56650,
             'ohlc': {'open': 262.45, 'high': 317.5, 'low': 262.2, 'close': 388.15}, 
             'change': -29.640602859719174, 'last_trade_time': datetime.datetime(2022, 4, 6, 9, 29, 50), 
             'oi': 1494450, 'oi_day_high': 1502600, 'oi_day_low': 1494450, 'exchange_timestamp': datetime.datetime(2022, 4, 6, 9, 29, 50),
             'depth': {
                 'buy': [
                 {'quantity': 50, 'price': 272.9, 'orders': 1}, 
                 {'quantity': 550, 'price': 272.8, 'orders': 5}, 
                 {'quantity': 50, 'price': 272.75, 'orders': 1}, 
                 {'quantity': 600, 'price': 272.7, 'orders': 2}, 
                 {'quantity': 50, 'price': 272.65, 'orders': 1}
                ], 
                 'sell': [
                     {'quantity': 300, 'price': 273.7, 'orders': 2}, 
                     {'quantity': 300, 'price': 273.75, 'orders': 5}, 
                     {'quantity': 450, 'price': 273.8, 'orders': 5}, 
                     {'quantity': 150, 'price': 273.9, 'orders': 1}, 
                     {'quantity': 550, 'price': 273.95, 'orders': 3}
                     ]
                    }
                }] */


        // $product = Product::create($request->all());
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
    
     public function getOrder()
    {
        $data = Order::where('status','Active')->pluck('token_id');
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //   $exist = Tick::where('status', 1)->get();
    //   if($exist){
    //       $deletable_data = Tick::where('status',1)->delete();
    //   }
    //         $data['properties'] = $request->input();
    //         $product = Tick::create($data);
           
    //     return response()->json(['message' => 'stored Successfully', 'data'=> $product]);
    
    
       $basketList = Basket::where('status','Active')->with(['orders' => function ($query) {
                                $query->where('status','Active');
                    
                }])->get();
        $tickers = $request->all();
        // dd($tickers);
        
        
        
         $b_list = json_decode($basketList,true);
        
         foreach($b_list as $basket_data){
             
            $newbasketPnl = 0;
            $prev_target = 0;
            $current_target = 0;
            $totalBasketPnl = 0;
            $totalBasketInv = 0;
            
            $init_target = 0;
            $stop_loss = 0;
            $target_strike = 0;
            $max_target_achived = 0;
            
             
             $init_target = $basket_data['init_target'];
             $stop_loss = $basket_data['stop_loss'];
             $target_strike = $basket_data['target_strike'];
             $prev_target = $basket_data['prev_current_target'];
             $current_target = $basket_data['current_target'];
             $max_target_achived = $basket_data['max_target_achived'];

             
             foreach($basket_data['orders'] as $eachOrder){
                $average_price = 0;
                $pnl = 0;
                $orderPnl = 0;
                $orderInvestment = 0;
                $pnl_perc = 0;
                $ltp = 0;
                $qty =0;
                
                 foreach($tickers as $eachTick){
                     
    
                     if ($eachTick['instrument_token'] == $eachOrder['token_id']){
                        // #Concluding Average Price
                      $average_price = $eachOrder['order_avg_price'];
                      
                      $ltp = $eachTick['last_price'];
                      $qty = $eachOrder['qty'];
                      
                     
                     if($average_price == 0){
                             $average_price = $eachTick['last_price']; 
                             $updateOrderData = Order::where('id', $eachOrder['id'])->first();
                             $updateOrderData['order_avg_price'] = $average_price;
                             $updateOrderData->save();
                        }
                        
                        // Concluding Pnl
                        
                        if($eachOrder['order_type'] == 'Buy'){
                            $pnl = $ltp - $average_price;
                            
                        }else{
                            // dd($average_price);
                            $pnl = $average_price - $ltp;
                        }
                        $orderPnl = $pnl * $qty;
                        $orderInvestment = $qty * $average_price;
                        
                        if($orderPnl != 0 && $orderInvestment != 0){
                            $pnl_perc = $orderPnl / $orderInvestment;
                        };
                        
                        $totalBasketPnl += $orderPnl;
                        $totalBasketInv += $orderInvestment;
                        
                        $updateOrderData = Order::where('id', $eachOrder['id'])->first();
                     
                     
                        $updateOrderData['pnl'] = $orderPnl;
                        $updateOrderData['pnl_perc'] = $pnl_perc;
                        $updateOrderData['status'] = 'Active';    
                        $updateOrderData['total_inv'] = $orderInvestment;
                        $updateOrderData['ltp'] = $ltp;
                        $updateOrderData->save();
                      
                     }
                     
                 }#Tick for loop
                     
             }#Order for loop
             
             
             if($totalBasketPnl >= 100000){
                 $newbasketPnl = substr((string) round($totalBasketPnl),0, 3).'000';
             }elseif($totalBasketPnl >= 10000){
                 $newbasketPnl = substr((string) round($totalBasketPnl),0, 3).'00';
             }elseif($totalBasketPnl >= 1000){
                 $newbasketPnl = substr((string) round($totalBasketPnl),0, 2).'00';
             }elseif(($totalBasketPnl >= 100) && ($totalBasketPnl < 1000)){
                 $newbasketPnl = substr((string) round($totalBasketPnl),0, 1).'00';
             }else{
                 $newbasketPnl = 0;
             }
             
             #Max Target Acheived Function
             
             if(($totalBasketPnl != 0) and ($max_target_achived < $totalBasketPnl)){
                 
                 $updateMaxPnl = Basket::where('id', $basket_data['id'])->first();
                 $updateMaxPnl['max_target_achived'] = $totalBasketPnl;
                 $updateMaxPnl->save();
                 
             }
             
             $newbasketPnl = (int) $newbasketPnl;
             
             if(($totalBasketPnl > $init_target) and ($totalBasketPnl != 0) and ($init_target !=0)){
                 $current_target = $newbasketPnl - $target_strike;
                 
                 $updateBasketData = Basket::where('id', $basket_data['id'])->first();
                 $updateBasketData['current_target'] = $current_target;
                 $updateBasketData->save();
             }
             
             if($prev_target < $current_target){
                 
                 $updateBasketData = Basket::where('id', $basket_data['id'])->first();
                 $updateBasketData['prev_current_target'] = $current_target;
                 $updateBasketData->save();
                 
             }
             
             #Target Square function
             
             if(($prev_target != 0) and ($totalBasketPnl != 0) and ($current_target != 0) and ($totalBasketPnl < $prev_target)){
                 
                 foreach($basket_data['orders'] as $basket_orders){
                     
                     $updateOrderData = Order::where('id', $basket_orders['id'])->first();
                     $updateOrderData['status'] = 'Squared';
                     $updateOrderData->save();
                     
                 }
                 
                 $updateBasketStatus = Basket::where('id', $basket_data['id'])->first();
                 $updateBasketStatus['status'] = 'Squared';
                 $updateBasketStatus['Pnl'] = $totalBasketPnl;
                 $updateBasketStatus->save();
             }
             
             #SL Square Funtion
             
             if((-abs($stop_loss) > $totalBasketPnl) and ($totalBasketPnl != 0) and ($stop_loss != 0)){
                 
                 foreach($basket_data['orders'] as $basket_orders){
                     
                     $updateOrderData = Order::where('id', $basket_orders['id'])->first();
                     $updateOrderData['status'] = 'Squared-SL';
                     $updateOrderData->save();
                     
                 }
                 
                 $updateBasketStatus = Basket::where('id', $basket_data['id'])->first();
                 $updateBasketStatus['status'] = 'Squared-SL';
                 $updateBasketStatus['Pnl'] = $totalBasketPnl;
                 $updateBasketStatus->save();
             }
             
             if($totalBasketPnl != 0){
                 $updateBasketPnl = Basket::where('id', $basket_data['id'])->first();
                 $updateBasketPnl['Pnl'] = $totalBasketPnl;
                 $updateBasketPnl->save();
             }
             
         }#Basket for loop
        

         $data = Order::where('status','Active')->pluck('token_id');
        
        return $data;
    
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
