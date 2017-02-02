<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class EncryptableModel extends Model
{
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->protectedColumns)) {
            $value = Crypt::encrypt($value);
        }

        parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->protectedColumns)) {
            $value = Crypt::decrypt($value);
        }

        return $value;
    }
}