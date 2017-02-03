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

    /**
     * @return Encrypter
     */
    public function getEncrypter()
    {
        if ($this->encrypter === null) {

            $key = $this->getAttribute($this->encryptionKeyAttribute);

            // Generate a new key
            if ($key === null) {
                $key = random_bytes(32);
                $this->setAttribute($this->encryptionKeyAttribute, $key);
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
    protected function encrypt($key, $value)
    {
        if ($this->isProtectedAttribute($key)) {
            return $this->getEncrypter()->encrypt($value);
        } elseif ($this->isEncryptionKeyAttribute($key)) {
            return Crypt::encrypt($value);
        } else {
            return $value;
        }
    }

    /**
     * Decrypt a value
     *
     * @param $value
     * @return mixed
     */
    protected function decrypt($key, $value)
    {
        if ($this->isProtectedAttribute($key)) {
            return $this->getEncrypter()->decrypt($value);
        } elseif ($this->isEncryptionKeyAttribute($key)) {
            return Crypt::decrypt($value);
        } else {
            return $value;
        }
    }

    /**
     * Whether a column is protected or not
     *
     * @param $key
     * @return bool
     */
    protected function isProtectedAttribute($key)
    {
        return is_array($this->protected) && in_array($key, $this->protected);
    }

    /**
     * Whether this is the column that stores the encryption key
     *
     * @param $key
     * @return bool
     */
    protected function isEncryptionKeyAttribute($key)
    {
        return $key === $this->encryptionKeyAttribute;
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
        $value = $this->encrypt($key, $value);

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

        return $this->decrypt($key, $value);
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
            $value = $this->decrypt($key, $value);
        }

        unset($attributes[$this->encryptionKeyAttribute]);

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
            $value = $this->decrypt($key, $value);
        }

        unset($attributes[$this->encryptionKeyAttribute]);

        return $attributes;
    }
}