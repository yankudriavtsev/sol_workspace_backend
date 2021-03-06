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

    public function update(int $entityId, array $data): void
    {
        ($this->getModel())::where(['id' => $entityId])->update($data);
    }

    public function exists(array $conditions): bool
    {
        return ($this->getModel())::where($conditions)->exists();
    }

    public function paginate(): Paginator
    {
        return ($this->getModel())::paginate();
    }

    public function getById(int $connectionId): ?Model
    {
        return ($this->getModel())::find($connectionId);
    }

    public function deleteByConditions(array $conditions): void
    {
        ($this->getModel())::where($conditions)->delete();
    }
}
