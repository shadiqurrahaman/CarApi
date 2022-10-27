<?php

namespace App\Repository;

interface RepoInterface{

  public function create($data);

  public function update($data,$id);
  
  public function delete($id);
      
}