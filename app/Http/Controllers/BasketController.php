<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basket;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    
       public function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::User();
        $user->id;
        $basketcat = Basket ::where('user_id',$user->id)->get();
        return view('basket.index', compact('basketcat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('basket.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $basket = New Basket;
        $basket->user_id = Auth::User()->id;
        $basket->basket_name = $request->basket_name;
        $basket->target_strike = $request->target_strike;
        $basket->init_target = $request->init_target;
        $basket->stop_loss = $request->stop_loss;
        $basket->scheduled_exec = $request->scheduled_exec;
        $basket->scheduled_sqoff = $request->scheduled_sqoff;
        $basket->recorring = $request->recorring;
        $basket->weekDays = $request->weekDays;
        $basket->strategy = $request->strategy;
        $basket->qty = $request->qty;
        $basket->created_by = "Self";
        $basket->status = "Active"; # Status as per the Scheduled Basket..
        $basket->intra_mis = $request->ORDER_TYPE; 
        $basket->save();
       

        $test = $request->data;
        
        foreach($test as $tes){
       
            $order = New Order;
            $order->user_id = Auth::User()->id;
            $order->basket_id = $basket->id;
            $order->qty = $request->qty;
            $order->token_id = $tes['token_id'];
            $order->token_name = $request['indices'].$tes['token_strike'];
            $order->order_type = $tes['order_type'];
            $order->status = "Active"; # Status as per the Scheduled Orders..
            $order->save();    
        }


        return redirect('basket');
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
          $order = Basket::findOrFail($id);
          if($request->has('stop_loss')){
         $order['stop_loss'] = $request->stop_loss;
          }
          if($request->has('target_strike')){
         $order['target_strike'] = $request->target_strike;
          }
          if($request->has('current_target')){
         $order['current_target'] = $request->current_target;
          }
          if($request->has('prev_current_target')){
         $order['prev_current_target'] = $request->prev_current_target;
          }
          if($request->has('pnl_perc')){
         $order['pnl_perc'] = $request->pnl_perc;
          }
         if($request->has('pnl')){
         $order['pnl'] = $request->pnl;    
         }
          if($request->has('init_target')){
         $order['init_target'] = $request->init_target;
          }
          if($request->has('max_target_achived')){
            $order['max_target_achived'] = $request-> max_target_achived ;
            }
              if($request->has('stop_loss')){
         $order['stop_loss'] = $request->stop_loss;
              }
         $order->save();
         return response()->json(['status'=>200, 'message'=>'Basket Updated Successfully !']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $basket = Basket::findOrFail($id);
        $basket->delete();
        return redirect('basket');
    }
}
