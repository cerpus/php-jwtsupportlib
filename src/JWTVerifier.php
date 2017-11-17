<?php
/**
 * Created by PhpStorm.
 * User: janespen
 * Date: 16.11.17
 * Time: 13:57
 */

namespace Cerpus\JWTSupport;


class JWTVerifier {
    private $verifiersByName;

    public function __construct($pubkeysByName) {
        $this->verifiersByName = [];
        foreach ($pubkeysByName as $name => $pubKey) {
            $this->verifiersByName[$name] = new JWTSupport($pubKey);
        }
    }

    public function verify($jwt) {
        foreach ($this->verifiersByName as $name => $jwtSupport) {
            $jwt = $jwtSupport->verify($jwt);
            if ($jwt) {
                return new ValidJWT($name, $jwt);
            }
        }
        return null;
    }
}