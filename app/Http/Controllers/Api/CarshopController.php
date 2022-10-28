<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car;
use App\Repository\CarRepository;
use Illuminate\Http\Request;

class CarshopController extends Controller
{
    private $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;   
    }

    public function savecar(Car $car)
    {   
        $newcar['make'] = $car->make;
        $newcar['model'] = $car->model;
        $data = $this->carRepository->create($newcar);
        return response()->json(['data'=>$data],200);
    }

    public function getcar($id)
    {
        return $this->carRepository->getcar($id);
    }

    public function addyear(Request $request,$id)
    {
        return $this->carRepository->addyear($id,$request->years);

    }

    public function carbyyear(Request $request)
    {
        //make year repository
        //select all car id from years
        //select all this id from car table 
        //save them in redis because this is an expensive query
        
        $years = explode(",",$request->years);

        return $years;
    }

}
