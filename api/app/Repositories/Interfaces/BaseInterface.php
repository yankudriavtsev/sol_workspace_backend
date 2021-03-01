<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\Paginator;

interface BaseInterface
{
    public function getOneByConditions(array $conditions): ?Model;
    
    public function updateOrCreate(array $attributes, array $values = []): Model;

    public function create(array $data): Model;

    public function exists(array $conditions): bool;

    public function paginate(): Paginator;

    public function getById(int $connectionId): ?Model;

    public function update(int $entityId, array $data): void;

    public function deleteByConditions(array $conditions): void;
}
