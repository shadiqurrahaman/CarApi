<?php
namespace App\Repository;
use App\Models\Car;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Carbon as carbon;

class CarRepository extends Repository
{   

    public function __construct(Car $car)
    {
        parent::__construct($car);
    }

    public function getcar($id)
    {   
        $check_local = Redis::get($id);
        
        if($check_local){
            return response()->json([json_decode($check_local)],200);
        }
        $remot_data = $this->model::where('id',$id)->with('year')->get();
        if(isset($remot_data)){
            Redis::set($id,$remot_data);
            return response()->json($remot_data,200);
        }


        return response()->json(['message'=>'No data found'],204);
    }

    public function addyear($id,$data)
    {   
       
        $car = $this->model::find($id);
         if(isset($car)){

             foreach($data->years as $key=>$value){
                $car->year()->updateOrCreate(['year'=>$value]);
             }
             $all_years_of_car = $car->where('id',$id)->with('year')->get();
    
             Redis::set($id, $all_years_of_car, 'EX', $data->expiry);
    
             return response()->json(['success'=>TRUE],200);
         }

         return response()->json(['success'=>FALSE],204);
    }

    public function carbyyear($years)
    {   
       $cars = DB::table('cars')->join('years','cars.id','=','years.car_id')
                ->whereIn('years.year',$years)    
                ->get();

        if(!empty($cars)){
            $output = [];
            foreach($cars as $key=>$value){
                    $temp['id'] = $value->car_id;
                    $temp['name'] = $value->make.' '.$value->model.' '.$value->year;
                    $locla_check = Redis::get($value->car_id);
                    if($locla_check){
                        $temp['years'] = json_decode($locla_check)[0]->year;
                    }else{
                        $temp['years'] = DB::table('years')->where('car_id','=',$value->car_id)->get();
                        Redis::set($value->car_id, $locla_check);
                    }
                    
                    array_push($output,$temp);
            }
            return response()->json(['cars'=>$output],200);
        }
        return response()->json(['message'=>'No data found'],204);



    }


}