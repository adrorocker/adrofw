<?php

namespace Adroframework\Hash;

class Hash
{
    public static function create($algo, $data, $saltKey)
    {
        $context = hash_init($algo, HASH_HMAC, $saltKey);
        hash_update($context, $data);
        return hash_final($context);
    }
}