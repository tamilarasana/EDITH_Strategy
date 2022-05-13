<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class InstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category_data = Http::get('https://api.kite.trade/instruments');
        $test = $category_data->body();
       
        $lines = preg_split('/[\n\r]/', $test);
       $ap = [];

        foreach($lines as $data){
            try {
            $each_data = explode(',',$data);
            $data1['instrument_token'] = $each_data[0];
            $data1['exchange_token'] = $each_data[1];
            $data1['tradingsymbol'] = $each_data[2];
            $data1['name'] = $each_data[3];
            $data1['last_price'] = $each_data[4];
            $data1['expiry'] = $each_data[5];
            $data1['strike'] = $each_data[6];
            $data1['tick_size'] = $each_data[7];
            $data1['lot_size'] = $each_data[8];
            $data1['instrument_type'] = $each_data[9];
            $data1['segment'] = $each_data[10];
            $data1['exchange'] = $each_data[11];

                Instrument::create($data1);
               

            } catch (\Exception $e) {
                array_push($ap, $e);
              continue;
            }
        
        }
        return response()->json(['status'=>200, 'message'=>'data added successfully !', 'errors' => $ap]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        
        
        $search = $request['query'];
         
        //  dd($search);
         
        // $order = Instrument::where("tradingsymbol", 'like', '%'.$search.'%')->get();
        
        $order = Instrument::query()->whereLike('tradingsymbol', $search)->get();
       
        
        return response()->json($order); 
        
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