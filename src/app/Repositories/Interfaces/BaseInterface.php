<?php

namespace App\Repositories\Interfaces;

interface BaseInterface
{
    public function getOneByConditions(array $conditions);
}