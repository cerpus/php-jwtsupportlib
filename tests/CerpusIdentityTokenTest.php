<?php

namespace Cerpus\JWTSupportTest;

class CerpusIdentityTokenTest extends \PHPUnit_Framework_TestCase {
    public function testCerpusIdentityTokenData() {
        $sampleTokenData = 'eyJpc3MiOiJodHRwczovL2F1dGguYmI0YnRlc3QuY2VycHVzLm5ldC8iLCJzdWIiOiJjYTY1ODI3Ny1iZDU5LTQwMzAtYTBhOC00NjI3ZGI3YTk3ZjAiLCJuYW1lIjoiSG9zdG1hc3RlciIsImFwcF9tZXRhZGF0YSI6eyJpZGVudGl0eUlkIjoiY2E2NTgyNzctYmQ1OS00MDMwLWEwYTgtNDYyN2RiN2E5N2YwIiwiZmlyc3ROYW1lIjoiQ2VycHVzIEFTIiwibGFzdE5hbWUiOiJIb3N0bWFzdGVyIiwiZGlzcGxheU5hbWUiOiJIb3N0bWFzdGVyIiwiZW1haWwiOiJob3N0bWFzdGVyQGNlcnB1cy5jb20iLCJhZGRpdGlvbmFsRW1haWxzIjpbXSwibm90VmVyaWZpZWRFbWFpbHMiOltdLCJhZG1pbiI6dHJ1ZX0sImV4cCI6MTUxMDkxNTMwNywiaWF0IjoxNTEwOTE0NzA3fQ';
        $jsonData = base64_decode($sampleTokenData, true);
        $decodedData = json_decode($jsonData);
        $token = new \Cerpus\JWTSupport\CerpusIdentityToken($decodedData);
        self::assertEquals("https://auth.bb4btest.cerpus.net/", $token->getIssuer());
        self::assertEquals("ca658277-bd59-4030-a0a8-4627db7a97f0", $token->getSubject());
        self::assertEquals("Hostmaster", $token->getName());
        self::assertEquals("ca658277-bd59-4030-a0a8-4627db7a97f0", $token->getIdentityId());
        self::assertEquals("Cerpus AS", $token->getFirstName());
        self::assertEquals("Hostmaster", $token->getLastName());
        self::assertEquals("Hostmaster", $token->getDisplayName());
        self::assertEquals("hostmaster@cerpus.com", $token->getEmail());
        self::assertEquals([], $token->getAdditionalEmails());
        self::assertEquals([], $token->getNotVerifiedEmails());
        self::assertTrue($token->isAdmin());
    }
}