<?php

namespace Cerpus\JWTSupport;


use Firebase\JWT\JWT;

class JWTSigner {
    private $privKey;

    public function __construct($privKeyBase64) {
        /*
         * URL-safe base64
         */
        $privKeyBase64 = str_replace('-', '+', $privKeyBase64);
        $privKeyBase64 = str_replace('_', '/', $privKeyBase64);

        $this->privKey = "-----BEGIN PRIVATE KEY-----\n".
            $privKeyBase64.
            "\n-----END PRIVATE KEY-----\n";
    }

    public function sign($payload) {
        return JWT::encode($payload, $this->privKey, 'RS256');
    }
}