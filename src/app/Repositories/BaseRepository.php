<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseInterface;
use Illuminate\Contracts\Pagination\Paginator;
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

    public function exists(array $conditions): bool
    {
        return ($this->getModel())::where($conditions)->exists();
    }

    public function paginate(): Paginator
    {
        return ($this->getModel())::paginate();
    }
}
