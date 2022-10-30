<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car;
use App\Repository\CarRepository;
use GuzzleHttp\Exception\RequestException;
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
        try{

            $data = $this->carRepository->create($newcar);
            return response()->json(['id'=>$data->id],201);

        }catch(RequestException $exception){

            return response()->bad_request($exception->getMessage());
        }
    }

    public function getcar($id)
    {   try{

            return $this->carRepository->getcar($id);

        }catch(RequestException $exception){

            return response()->bad_request($exception->getMessage());
        }
    }

    public function addyear(Request $request,$id)
    {   
        if (!$id) {
            return response()->json(['message'=>"Invalid id"],400);
        }

        try{

            return $this->carRepository->addyear($id,$request);
        }catch(RequestException $exception){

            return response()->bad_request($exception->getMessage());
        }

    }

    public function carbyyear(Request $request)
    {
                
        $years = explode(",",$request->years);
        
        try{

            return $this->carRepository->carbyyear($years);
        }catch(RequestException $exception){

            return response()->bad_request($exception->getMessage());
        }

    }

}
