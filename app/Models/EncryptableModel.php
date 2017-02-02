<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncryptableModel extends Model
{
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->protectedColumns)) {
            $value = '__' . $value;
        }

        parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->protectedColumns)) {
            $value = substr($value, 2);
        }

        return $value;
    }
}