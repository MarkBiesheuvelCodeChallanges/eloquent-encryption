<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Concerns\ProtectedAttributes;

    /**
     * The attributes that are protected
     *
     * @var array
     */
    protected $protected = [
        'title',
        'description',
        'price',
    ];
}