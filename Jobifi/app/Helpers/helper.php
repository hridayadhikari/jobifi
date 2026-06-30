<?php

if (!function_exists('encryptId')) {

    function encryptId($id)
    {
        $key = hash('sha256', config('app.id_encryption_key'), true);

        $cipher = 'AES-128-ECB';

        $encrypted = openssl_encrypt(
            (string)$id,
            $cipher,
            $key,
            OPENSSL_RAW_DATA
        );

        return rtrim(strtr(base64_encode($encrypted), '+/', '-_'), '=');
    }
}

if (!function_exists('decryptId')) {

    function decryptId($encrypted)
    {
        $key = hash('sha256', config('app.id_encryption_key'), true);

        $cipher = 'AES-128-ECB';

        $encrypted = base64_decode(strtr($encrypted, '-_', '+/'));

        return openssl_decrypt(
            $encrypted,
            $cipher,
            $key,
            OPENSSL_RAW_DATA
        );
    }
}