<?php
namespace App\Repository;
use App\Models\Car;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CarRepository extends Repository
{   

    public function __construct(Car $car)
    {
        parent::__construct($car);
    }

    public function getcar($id)
    {   $check_local = Redis::get($id);
        if($check_local){
            return $check_local;
        }

        $remot_data = $this->model::where('id',$id)->with('year')->get();
        Redis::set($id,$remot_data);

        return $remot_data;
    }

    public function addyear($id,$data)
    {    
        
         $car = $this->model::find($id);
         foreach($data as $key=>$value){
            $car->year()->updateOrCreate(['year'=>$value]);
         }
         $all_years_of_car = $car->where('id',$id)->with('year')->get();

         Redis::set($id, $all_years_of_car, 'EX', $data->expiry);

         return TRUE;
    }

    public function carbyyear($years)
    {   
       $cars = DB::table('cars')->join('years','cars.id','=','years.car_id')
                ->whereIn('years.year',$years)    
                ->get();
        
        $output = [];
        foreach($cars as $key=>$value){
                $temp['id'] = $value->car_id;
                $temp['name'] = $value->make.' '.$value->model.' '.$value->year;
                $locla_check = Redis::get($value->car_id);
                if(!$locla_check){
                $locla_check = DB::table('years')->where('car_id','=',$value->car_id)->get();
                Redis::set($value->car_id, $locla_check);
                }
                $temp['years'] = $locla_check;
                array_push($output,$temp);
        }
        return $output;



    }


}