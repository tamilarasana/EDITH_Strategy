<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Basket;
use Illuminate\Http\Request;
use App\Models\Webhookbasket;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
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
        $basket = Basket ::where('user_id',$user->id)->get();
        return view('strategy-builder',['basket' => $basket]);
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
        // dd($request->all());
        $order = New Order;
        $order->user_id = Auth::User()->id;
        $order->basket_id = $request->basket_id;
        $order->token_name = $request->token_name;
        $order->token_id = $request->token_id;
        $order->leg_type = $request->leg_type;
        $order->qty = $request->qty;
        $order->status = $request->status;
        $order->order_type = $request->order_type;
        $order->delta = $request->delta;
        $order->theta = $request->theta;
        $order->vega = $request->vega;
        $order->gamma = $request->gamma;
        $order->save();
        return redirect('holdings');
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
    public function getOrder()
    {
        $data = Order::where('status','Active')->pluck('token_id');
        return $data;
    }
    
    public function getAllOrder()
    {

        $user = Auth::User();
        $user_id = $user->id;
                $data = Basket::where('user_id', $user_id)->orderBy('status', 'ASC')->orderBy('created_at', 'DESC')->with('orders')->get();
                
                                // $data = Basket::where('user_id', $user_id)->orderBy('status', 'ASC')->orderBy('created_at', 'DESC')->with(['orders' => function ($query) {$query->where('status', '=', 'Active');}])->get();

        return response()->json(['status'=>200,'data'=>$data]);

    }

    public function getAllWebhookOrder()
    {

        $user = Auth::User();
        $user_id = $user->id;
        $data = Webhookbasket::where('user_id',$user_id)->orderBy('updated_at', 'DESC')->with('webhook')->get();
               
        return response()->json(['status'=>200,'data'=>$data]);

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
         $order = Order::findOrFail($id);         
        if($request->has('ltp')){
             $order['ltp'] = $request->ltp;
        }
        if($request->has('order_avg_price')){
            $order['order_avg_price'] = $request->order_avg_price;
        }
         
        if($request->has('pnl')){
            $order['pnl'] = $request->pnl;
          }
        if($request->has('pnl_perc')){
            $order['pnl_perc'] = $request->pnl_perc;
          }
        if($request->has('status')){
            $order['status'] = $request->status;    
         }
          if($request->has('total_inv')){
         $order['total_inv'] = $request->total_inv;
          }
           if($request->has('init_target')){
         $order['init_target'] = $request->init_target;
           }
            if($request->has('current_target')){
         $order['current_target'] = $request->current_target;
            }
            if($request->has('stop_loss')){
         $order['stop_loss'] = $request->stop_loss;
            }
         $order->save();
         return response()->json(['status'=>200, 'message'=>'Order Updated Successfully !']);
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
    
    public function exitOrder($id){
        $basket = Basket::findOrFail($id);
        $basket -> status = 'Squared';
        $basket->save();
        $order = Order::where('basket_id',$id)->get();
        foreach($order  as $ord){
            $ord ->status = 'Squared';
            $exitprice =  $ord->ltp;
            $ord->exit_price = $exitprice;
            $ord->save();
        }
    }


}
