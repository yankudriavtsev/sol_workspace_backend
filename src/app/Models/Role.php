<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'is_active',
    ];

    protected $casts = [
        'is_editable' => 'boolean',
        'is_active'  => 'boolean',
    ];

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }
}
