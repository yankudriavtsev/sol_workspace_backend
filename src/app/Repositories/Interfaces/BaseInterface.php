<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface BaseInterface
{
    public function getOneByConditions(array $conditions): ?Model;
    
    public function updateOrCreate(array $attributes, array $values = []): Model;

    public function create(array $data): Model;

    public function exists(array $conditions): bool;
}