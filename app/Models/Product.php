<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Concerns\ProtectedAttributes;

    /**
     * The attribute that stores the unique encryption key
     *
     * @var string
     */
    protected $encryptionKeyAttribute = 'encryption_key';

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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float',
    ];

}