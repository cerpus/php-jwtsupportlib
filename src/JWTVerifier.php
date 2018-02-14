<?php
/**
 * Created by PhpStorm.
 * User: janespen
 * Date: 16.11.17
 * Time: 13:57
 */

namespace Cerpus\JWTSupport;


use Firebase\JWT\SignatureInvalidException;
use JOSE_JWK;

class JWTVerifier {
    private $verifiersByName;

    private function strStartsWithIgnoreCase($str, $startsWith) {
        $len = strlen($startsWith);
        if (strlen($str) < $len) {
            return FALSE;
        }
        $compareWith = substr($str, 0, $len);
        return (strtolower($startsWith) == strtolower($compareWith));
    }

    private function jwkToPubKey($jwk) {
        $rsa = JOSE_JWK::decode($jwk);
        $pubKey = $rsa->getPublicKey();
        $lines = explode("\n", $pubKey);
        $lines = array_map(function ($ln) {
            return trim($ln);
        }, $lines);
        $lines = array_filter($lines, function ($ln) {
            $startsWith = "---";
            $len = strlen($startsWith);
            if (strlen($ln) < $len) {
                return TRUE;
            }
            $compareWith = substr($ln,0, $len);
            return $startsWith != $compareWith;
        });
        return implode("", $lines);
    }

    protected function downloadResource($url) {
        return file_get_contents($url);
    }

    public function __construct($pubkeysByName) {
        $this->verifiersByName = [];
        foreach ($pubkeysByName as $name => $pubKey) {
            if ($this->strStartsWithIgnoreCase($pubKey, "http://") || $this->strStartsWithIgnoreCase($pubKey, "https://")) {
                $jwkData = $this->downloadResource($pubKey);
                $php = json_decode($jwkData, TRUE);
                $keys = array_map(function ($jwk) {
                    return $this->jwkToPubKey($jwk);
                }, $php['keys']);
                $this->verifiersByName[$name] = new JWTSupportMultipleKeys($keys);
            } else {
                $this->verifiersByName[$name] = new JWTSupport($pubKey);
            }
        }
    }

    /**
     * @param $name
     *
     * @return \Cerpus\JWTSupport\JWTSupportAbstract
     */
    public function getVerifierByName($name) {
        return $this->verifiersByName[$name];
    }

    public function verify($jwt) {
        $exception = NULL;
        foreach ($this->verifiersByName as $name => $jwtSupport) {
            try {
                $jwt = $jwtSupport->verify($jwt);
                if ($jwt) {
                    return new ValidJWT($name, $jwt);
                }
            } catch (SignatureInvalidException $e) {
                $exception = $e;
            }
        }
        return null;
    }
}