<?php

namespace Cerpus\JWTSupport;


use Firebase\JWT\JWT;

class JWTSupport {
    private $publicKey;
    private $leeway;

    public function __construct($publicKeyBase64) {
        /*
         * URL-safe base64
         */
        $publicKeyBase64 = str_replace('-', '+', $publicKeyBase64);
        $publicKeyBase64 = str_replace('_', '/', $publicKeyBase64);

        $this->publicKey = "-----BEGIN PUBLIC KEY-----\n".
            $publicKeyBase64.
            "\n-----END PUBLIC KEY-----\n";
    }

    /**
     * @param $jwt
     *
     * @return null|object The JWT's payload as a PHP object
     *
     * @throws UnexpectedValueException     Provided JWT was invalid
     * @throws BeforeValidException         Provided JWT is trying to be used before it's eligible as defined by 'nbf'
     * @throws BeforeValidException         Provided JWT is trying to be used before it's been created as defined by 'iat'
     * @throws ExpiredException             Provided JWT has since expired, as defined by the 'exp' claim
     *
     */
    public function verify($jwt) {
        JWT::$leeway = $this->leeway;
        try {
            return JWT::decode($jwt, $this->publicKey, ['RS256']);
        } catch (SignatureInvalidException $e) {
            return null;
        }
    }

    /**
     * @return mixed
     */
    public function getLeeway() {
        return $this->leeway;
    }

    /**
     * @param mixed $leeway
     */
    public function setLeeway($leeway) {
        $this->leeway = $leeway;
    }
}