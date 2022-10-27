<?php
namespace App\Repository;
use Illuminate\Database\Eloquent\Model;
class Repository implements RepoInterface{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create($data)
    {
        $model = $this->model->create($data);
        return $model;
    }

    public function update($data,$id)
    {
        $info = $this->model->find($id);
        if($info){
            return $this->model->update($data);
        }
        return response()->json(['mesage'=>'Model Not Found'],401);
    }
  
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
    
}