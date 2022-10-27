<?php
namespace App\Repository;
use App\Models\Car;

class CarRepository extends Repository
{   

    public function __construct(Car $car)
    {
        parent::__construct($car);
    }


}