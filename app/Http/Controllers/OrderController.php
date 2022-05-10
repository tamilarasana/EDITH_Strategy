<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Basket;
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

        // $data->user_id = Auth::User()->id;

        // $user = Auth::User();
        // $user->id;
        // $user = Auth::user();
        // $user_id = $user->id;
        

        $user = Auth::User();
        $user->id;
        $basket = Basket ::where('user_id',$user->id)->get();
        // $basket = Basket::all();
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

    public function exitPrice($id){
        $order = Order::findOrFail($id);
        $exitprice =  $order->ltp;
        $order->exit_price = $exitprice;
        $order->status = 'squared';
        $order->save();
    }
}
