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
        return $data;
    }
}
