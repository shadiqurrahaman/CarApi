<?php
namespace App\Repository;
use App\Models\Car;

class CarRepository extends Repository
{   

    public function __construct(Car $car)
    {
        parent::__construct($car);
    }

    public function getcar($id)
    {
        return $this->model::where('id',$id)->with('year')->get();
    }

    public function addyear($id,$data)
    {    
        
         $car = $this->model::find($id);
         
         foreach($data as $key=>$value){
            $car->year()->updateOrCreate(['year'=>$value]);
         }

         return TRUE;
    }


}