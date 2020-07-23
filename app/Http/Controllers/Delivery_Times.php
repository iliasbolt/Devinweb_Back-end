<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Delivery_Times extends Controller
{
   /* public function showAll()
    {
        return response()->json([
            'success' => 'ok',
            'data' => \App\Delivery_times::all()
        ]);
    }*/

    public function AddDeliveryTime(Request $request)
    {
        try {
            $delivery_at = $request->get('delivery_at');


            //test if delivery_at is empty or null ;
            if(!isset($delivery_at) || is_null($delivery_at) || empty($delivery_at))
                return response()->json([
                    'success' => 'no',
                    'error_info' => 'Please give a delivery time !!',
                ]);


            $delivery = new \App\Delivery_times();
            $delivery->delivery_at = $delivery_at ;
            $delivery->created_at = Carbon::now();
            $delivery->updated_at = Carbon::now();
            $delivery->save();

            //if All good and the data is saved Successfully i return ok and the current saved object
            return response()->json([
                'success'=>'ok',
                'Inserted_data'=>$delivery,
            ]);
        }catch (\Exception $ex)
        {
            //if exception is thrown i will catch it and return the problem .
            return response()->json([
                'success' => 'no',
                'exception' => $ex,
            ]);
        }

    }


    public function excludeDelivery(Request $request,$city,$date)
    {
        //test to exclude the future commandes (delivery) not the old ones
        if(Carbon::now() > $date)
            return "the delivery is already passed !! ";


        $delivery_at = $request->get('delivery_at');


        if(is_array($delivery_at)) //!!!! WARNING you should send array in this format  {"ids" : [1,2,3,...]}   .
        {
            //that mean the admin choose some deliveries time span to exclude (the array must containe id of the deliveries)

           \App\Delivery_times::where('deliv_date','=',$date)
               ->join('cities_delivery_times','cities_id','=','cities_delivery_times.id')
               ->whereIn('delivery_times.id',$delivery_at['ids'])
               ->where('cities_id','=',$city)
               ->update(['excluded'=>1]);

           //now we can exclude the specific deleveries in the array
        }
        else{

            //that mean he choose to exclude all the deliveries of the specific date (in front-end maybe a button or simple check box  send "all" to back-end)
            if($delivery_at == "all")
            {
                \App\Delivery_times::where('deliv_date','=',''.$date)
                    ->join('cities_delivery_times','cities_id','=','cities_delivery_times.id')
                    ->where('cities_id','=',$city)
                    ->update(['excluded'=>1]);

                //nice now we can exclude all the deliveries of a specific date and specific city
                return response()->json([
                   'success'=>'ok',
                   'info'=>'all the deliveries of this date and city is excluded',
                ]);
            }
            else{
                return response()->json([
                   'success'=>'no',
                   'info'=>"format not supported please send (array of ids or 'all' to exclude all)",
                ]);
            }
        }

    }
}
