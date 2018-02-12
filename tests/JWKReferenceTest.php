<?php

class JWKReferenceTest extends \PHPUnit_Framework_TestCase {
    public function testReferenceJwk() {
        $jwks = "{\"keys\":[{\"alg\":\"RS256\",\"kty\":\"RSA\",\"use\":\"sig\",\"x5c\":[\"MIIC6jCCAdKgAwIBAgIJXvRBRTPEoFxtMA0GCSqGSIb3DQEBCwUAMBwxGjAYBgNVBAMTEW5kbGEuZXUuYXV0aDAuY29tMB4XDTE3MDMwNzA4NDM1MFoXDTMwMTExNDA4NDM1MFowHDEaMBgGA1UEAxMRbmRsYS5ldS5hdXRoMC5jb20wggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDioAGXH0uzL6PC32yiD6RseSQvD4Qw4KeVdfLJizw7qCxUaKRpb5PhokUPS+lTKT6wiiVidLSijknql2bAFWdv/d43HWA+K+rWQh7OW3Fd4hIHRWnTaezlMnh0l1gxuWaUs72CrdlucBrq3cfgAULwnxaxbFSzJSpOov996n2o6G+FTU1RP2LBG12p3WVVb6mEcRk56lITxNVSYU1W5R38MRJT/0MOd5N2DSRHqH/okQaoq7nHugvw3cO46R7vpDn8pin5rH2GegmmJGGswLkEqscL0kGjSu3hW7T42+QylJDBaeMUeDklKojCgGf2RMKnPagYYUTWHC3HoqLaAS45AgMBAAGjLzAtMAwGA1UdEwQFMAMBAf8wHQYDVR0OBBYEFBxdC6FRr+zdPZS1UR3T3NkiFNmWMA0GCSqGSIb3DQEBCwUAA4IBAQBaVtIfgsiNlv4RY/jZ7x5cqx/gJMHw9Mc/SQXf3TwY8XnF6wt4EQ/w6igXRiCl8ufN3KEbu+Kfpdbr4Rhm0v9RqiCU76u/S30ecpjzB57Lczg1SeTjFjmaRtCVzJIFmoZ0vdSuZCSW0wYjLwX8XCaY+CTuhgdO38RDYBsTjC3NdpIvjCPOaK10P4TpH8XOGPHcSKlMqXRP526lT3F4Mw/+F+oSv5F+IOYUmUqoVPNOUkSwREMesMkiLm3jbHsofAD8MLT7XhIO6iKkJUgF2n5KLJpn9HH8SBjf6U9rKRyyVsZ9wrSQxDCpXfkO+MrwmJWzLPbobY+iXcc6HDUJU4t2\"],\"n\":\"4qABlx9Lsy-jwt9sog-kbHkkLw-EMOCnlXXyyYs8O6gsVGikaW-T4aJFD0vpUyk-sIolYnS0oo5J6pdmwBVnb_3eNx1gPivq1kIezltxXeISB0Vp02ns5TJ4dJdYMblmlLO9gq3ZbnAa6t3H4AFC8J8WsWxUsyUqTqL_fep9qOhvhU1NUT9iwRtdqd1lVW-phHEZOepSE8TVUmFNVuUd_DESU_9DDneTdg0kR6h_6JEGqKu5x7oL8N3DuOke76Q5_KYp-ax9hnoJpiRhrMC5BKrHC9JBo0rt4Vu0-NvkMpSQwWnjFHg5JSqIwoBn9kTCpz2oGGFE1hwtx6Ki2gEuOQ\",\"e\":\"AQAB\",\"kid\":\"OEI1MUU4ODk5NzM5MzI2MzZDODk1N0YwQzdDMDQyODVCQzQ3QTI0MA\",\"x5t\":\"OEI1MUU4ODk5NzM5MzI2MzZDODk1N0YwQzdDMDQyODVCQzQ3QTI0MA\"}]}";
        $php = json_decode($jwks, TRUE);
        $keys = $php['keys'];
        $components = $keys[array_keys($keys)[0]];
        $rsa = JOSE_JWK::decode($components);
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
        $pubKey = implode("", $lines);
        echo "Public key:\n".$pubKey."\n";
        $jwtSupport = new \Cerpus\JWTSupport\JWTSupport($pubKey);
        $exampleToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6Ik9FSTFNVVU0T0RrNU56TTVNekkyTXpaRE9EazFOMFl3UXpkRE1EUXlPRFZDUXpRM1FUSTBNQSJ9.eyJodHRwczovL25kbGEubm8vY2xpZW50X2lkIjoicUhRZ2pndTc3TUFJeWhVdnVqaU5mWDQwWDUxU1hacjMiLCJpc3MiOiJodHRwczovL25kbGEuZXUuYXV0aDAuY29tLyIsInN1YiI6InFIUWdqZ3U3N01BSXloVXZ1amlOZlg0MFg1MVNYWnIzQGNsaWVudHMiLCJhdWQiOiJuZGxhX3N5c3RlbSIsImlhdCI6MTUxODE4NjczNCwiZXhwIjoxNTE4MTg3MzM0LCJhenAiOiJxSFFnamd1NzdNQUl5aFV2dWppTmZYNDBYNTFTWFpyMyIsInNjb3BlIjoiYXJ0aWNsZXMtc3RhZ2luZzp3cml0ZSBhcnRpY2xlcy1icnVrZXJ0ZXN0OndyaXRlIGFydGljbGVzLXByb2Q6d3JpdGUgYXJ0aWNsZXMtdGVzdDp3cml0ZSIsImd0eSI6ImNsaWVudC1jcmVkZW50aWFscyJ9.ERj57mJ6PimOpjDYPS1Sp3nse_tOLfEhuwRK89UeYVOfdMvtDWmDoae4xFF3OGOSzMLkhmS0GPoOTfLS6Ad2yN01xB8V2qB-rfw8gxByS1nCT-Z9hSqDn37OIaDYSpjvlsPoZjLjoxXpQYXqDt566cpDbHD6OSNS2rp36meSds40A2v4eIqaazQXN5ZblSBMq981ZwAVfggxcoHAEXG8NS-Ba4mkPo3cXa1Ko5MJ9z1P0XsEQuzqaRpdYlirsoHVliAveMU4ds0gS-RsKUrxlBC5ddwIq_xmFMay9e3d87Y7E1lI00qKc8dxc0S1qOpbjXPocaJndFVoLCWYGAaaUw";
        $jwtSupport->setLeeway(PHP_INT_MAX/4);
        $tokenData = $jwtSupport->verify($exampleToken);
        print_r($tokenData);
    }
}