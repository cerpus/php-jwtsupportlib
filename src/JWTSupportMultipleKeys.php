<?php

namespace Cerpus\JWTSupport;


class JWTSupportMultipleKeys extends JWTSupportAbstract {
    private $children = [];
    private $leeway;

    public function __construct($publicKeys) {
        foreach ($publicKeys as $publicKey) {
            $this->children[] = new JWTSupport($publicKey);
        }
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
        foreach ($this->children as $child) {
            $verified = $child->verify($jwt);
            if ($verified) {
                return $verified;
            }
        }
        return NULL;
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
        foreach ($this->children as $child) {
            $child->setLeeway($leeway);
        }
    }
}