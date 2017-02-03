<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Encryption\Encrypter;

/**
 * Class ProtectedAttributes
 *
 * Overrides functions from Illuminate\Database\Eloquent\Concerns\HasAttributes
 *
 * @package App\Models\Concerns
 */
trait ProtectedAttributes
{
    /**
     * @var Encrypter
     */
    protected $encrypter = null;

    public function getEncrypter()
    {
        if ($this->encrypter === null) {

            if ($this->encryption_key === null) {
                // Generate new key for new object
                $key = random_bytes(32);
                // Encrypt the key with the application key
                $this->encryption_key = Crypt::encrypt($key);
            } else {
                // Decrypt the key of an existing row
                $key = Crypt::decrypt($this->encryption_key);
            }

            // Create new Encrypter object with key from this record
            $this->encrypter = new Encrypter($key, 'AES-256-CBC');
        }

        return $this->encrypter;
    }

    /**
     * Encrypt a value
     *
     * @param $value
     * @return mixed
     */
    protected function encrypt($value)
    {
        return $this->getEncrypter()->encrypt($value);
    }

    /**
     * Decrypt a value
     *
     * @param $value
     * @return mixed
     */
    protected function decrypt($value)
    {
        return $this->getEncrypter()->decrypt($value);
    }

    /**
     * Whether a column is protected or not
     *
     * @param $key
     * @return bool
     */
    protected function isProtected($key)
    {
        return is_array($this->protected) && in_array($key, $this->protected);
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        if ($this->isProtected($key)) {
            $value = $this->encrypt($value);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Get a plain attribute (not a relationship).
     *
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
     * Get an attribute array of all arrayable attributes.
     *
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
     * Get all of the current attributes on the model.
     *
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