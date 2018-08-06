<?php

namespace Cerpus\JWTSupportTest;

use Cerpus\JWTSupport\JWTVerifier;

class JWTVerifierTest extends \PHPUnit_Framework_TestCase {
    /*
     * @Test
     */
    public function testVerify() {
        $testToken = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWV9.EkN-DOsnsuRjRO6BxXemmJDm3HbxrbRzXglbN2S4sOkopdU4IsDxTI8jO19W_A4K8ZPJijNLis4EZsHeY559a4DFOd50_OqgHGuERTqYZyuhtF39yxJPAjUESwxk2J5k_4zM3O-vtd1Ghyo4IbqKKSy6J9mTniYJPenn5-HIirE';
        $pubKey = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDdlatRjRjogo3WojgGHFHYLugdUWAY9iR3fy4arWNA1KoS8kVw33cJibXr8bvwUAUparCwlvdbH6dvEOfou0/gCFQsHUfQrSDv+MuSUMAe8jzKE4qW+jK+xQU9a03GUnKHkkle+Q0pX/g6jXZ7r1/xAK5Do2kQ+X5xK9cipRgEKwIDAQAB';

        $verifier = new JWTVerifier(
            [
                'test' => $pubKey
            ]
        );
        $verified = $verifier->verify($testToken);
        self::assertNotNull($verified);
        self::assertEquals("test", $verified->getName());
        $jwt = $verified->getJwt();
        self::assertEquals("John Doe", $jwt->name);
        self::assertEquals("1234567890", $jwt->sub);
        self::assertTrue($jwt->admin);
    }
    /*
     * @Test
     */
    public function testVerifyInvalidToken() {
        $testToken = '1930af04-d0c5-44f3-bfc5-2cb6946bb351';
        $pubKey = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDdlatRjRjogo3WojgGHFHYLugdUWAY9iR3fy4arWNA1KoS8kVw33cJibXr8bvwUAUparCwlvdbH6dvEOfou0/gCFQsHUfQrSDv+MuSUMAe8jzKE4qW+jK+xQU9a03GUnKHkkle+Q0pX/g6jXZ7r1/xAK5Do2kQ+X5xK9cipRgEKwIDAQAB';

        $verifier = new JWTVerifier(
            [
                'test' => $pubKey
            ]
        );
        $verified = $verifier->verify($testToken);
        self::assertNull($verified);
    }
}