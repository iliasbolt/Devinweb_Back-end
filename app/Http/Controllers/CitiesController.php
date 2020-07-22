<?php

namespace App\Http\Controllers;

use App\Cities;
use Carbon\Carbon;
use DateTime;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use phpDocumentor\Reflection\Types\Array_;

class CitiesController extends Controller
{
    public function AddCity(Request $request)
    {
        try{
                 $name = $request->get('name');

                 //test if $name is empty or null ;
                if(!isset($name) || is_null($name) || empty($name))
                    return response()->json([
                       'success' => 'no',
                       'info' => 'Please give a name !!',
                    ]);


                $citi = new Cities();
                $citi->name = $name;
                $citi->created_at = Carbon::now();
                $citi->updated_at = Carbon::now();
                $citi->save();

                //if All good and the data is saved Successfully i return ok and the current saved object
                return response()->json([
                    'success' => "ok",
                    'Data' => $citi,
                ]);
        }
        catch (Exception $ex)
        {
            //if exception is thrown i will catch it and return the problem .
            return response()->json([
                'success' => 'no',
                'exception' => $ex,
            ]);
        }


    }
    public function ShowAllCities()
    {
        //return All The Cities from the database .
        return response()->json([
            'success'=>'ok',
            'data'=>Cities::all(),

        ]);
    }

    public function AttachingToDelivery(Request $request,$cities)
    {
        $delivery_time = $request->get('delivery_time');

        //test if delivery time is empty or null or not set ;
        if(!isset($delivery_time) || is_null($delivery_time) || empty($delivery_time))
            return response()->json([
                'success' => 'no',
                'info' => 'Please give a delivery time !!',
            ]);

        try {
            //test if delivery_time is Array of ids

                //!!!! WARNING you should send array in this format  {"ids" : [1,2,3,...]}   .
                    if(is_array($delivery_time))
                    {
                        $city = Cities::findOrFail($cities);
                        $city->delivery_time()->sync($delivery_time['ids']);

                        return \response()->json([
                            'success' => 'ok',
                            'info' => 'data inserted successfully',
                            'data' => $delivery_time,
                        ]);
                    }
                    else { //if its not array

                        $city = Cities::findOrFail($cities);
                        $delivery = \App\Delivery_times::findOrFail($delivery_time);
                        $city->delivery_time()->attach($delivery);

                            return \response()->json([
                                'success' => 'ok',
                                'info' => 'data inserted successfully',
                                'data' => $delivery_time,
                            ]);
                        }

        }catch (Exception $ex){

            //if exception is thrown i will catch it and return the problem .
            return response()->json([
                'success' => 'no',
                'exception' => $ex,
            ]);
        }


    }

    public function UserEndpoint($city,$datetime)
    {


        if(!isset($datetime)||is_null($datetime) || empty($datetime))
            return \response()->json([
                'success'=>'no',
                'info'=>'Do not send Empty values'
            ]);

        $data = DB::table('cities_delivery_times')
            ->join('delivery_times','delivery_times.id','=','cities_delivery_times.delivery_times_id')
            ->where('cities_delivery_times.cities_id',$city)
            ->whereBetween('deliv_date',[Carbon::now(),Carbon::now()->addDays($datetime-1)])
            ->get();

        //now we have the choosen city with her dates and time stamps with the exacts results
        $days = 0;
        $array = Array();
        for($i=0 ; $i<count($data) ; $i++)
        {
            $day_name = $data[$i]->deliv_date;
            $d = new DateTime($day_name);
            $array[] = ['day_name'=> $d->format('l'),'date'=>$day_name,'delivery_items'=> $data[$i]];
        }


       return \response()->json([
          'dates' => $array
       ]);
    }

}

