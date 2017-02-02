<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class EncryptableModel extends Model
{
    /**
     * @param $value
     * @return mixed
     */
    protected function encrypt($value)
    {
        return Crypt::encrypt($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function decrypt($value)
    {
        return Crypt::decrypt($value);
    }

    /**
     * @param $key
     * @return bool
     */
    protected function isProtected($key)
    {
        return in_array($key, $this->protectedColumns);
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function setAttribute($key, $value)
    {
        if ($this->isProtected($key)) {
            $value = $this->encrypt($value);
        }

        parent::setAttribute($key, $value);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getAttributeFromArray($key)
    {
        $value = parent::getAttributeFromArray($key);

        if ($this->isProtected($key)) {
            $value = $this->decrypt($value);
        }

        return $value;
    }

    /**
     * @return array
     */
    public function getArrayableAttributes()
    {
        $attributes = parent::getArrayableAttributes();

        foreach ($attributes as $key => &$value) {
            if ($this->isProtected($key)) {
                $value = $this->decrypt($value);
            }
        }

        return $attributes;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        $attributes = parent::getAttributes();

        foreach ($attributes as $key => &$value) {
            if ($this->isProtected($key)) {
                $value = $this->decrypt($value);
            }
        }

        return $attributes;
    }
}