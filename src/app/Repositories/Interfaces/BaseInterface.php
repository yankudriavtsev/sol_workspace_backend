<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface BaseInterface
{
    public function getOneByConditions(array $conditions): ?Model;
    
    public function updateOrCreate(array $attributes, array $values = []): Model;
}