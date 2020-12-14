<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseInterface
{
    abstract protected function getModel(): string;

    public function getOneByConditions(array $conditions): ?Model
    {
        return ($this->getModel())::where($conditions)->first();
    }
    
    public function updateOrCreate(array $attributes, array $values = []): Model
    {
        return ($this->getModel())::updateOrCreate($attributes, $values);
    }

    public function create(array $data): Model
    {
        return ($this->getModel())::create($data);
    }
}
