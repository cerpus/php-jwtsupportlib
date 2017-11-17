<?php
/**
 * Created by PhpStorm.
 * User: janespen
 * Date: 16.11.17
 * Time: 13:54
 */

namespace Cerpus\JWTSupport;


class ValidJWT {
    private $name;
    private $jwt;

    public function __construct($name, $jwt) {
        $this->name = $name;
        $this->jwt = $jwt;
    }

    public function getName() {
        return $this->name;
    }

    public function getJwt() {
        return $this->jwt;
    }
}