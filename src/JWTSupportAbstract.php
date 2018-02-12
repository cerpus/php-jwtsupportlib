<?php

namespace Cerpus\JWTSupport;


use Firebase\JWT\JWT;

abstract class JWTSupportAbstract {
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
    public abstract function verify($jwt);

    /**
     * @return mixed
     */
    public abstract function getLeeway();

    /**
     * @param mixed $leeway
     */
    public abstract function setLeeway($leeway);
}