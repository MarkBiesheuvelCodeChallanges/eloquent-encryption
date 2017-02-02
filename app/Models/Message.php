<?php

namespace App\Models;

class Message extends EncryptableModel
{
    /**
     * Encrypt the to and content field but not the from field
     *
     * @var array
     */
    protected $protectedColumns = [
        'to',
        'content',
    ];
}