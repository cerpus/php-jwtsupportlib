<?php

namespace Cerpus\JWTSupport;


class CerpusIdentityToken {
    private $identityId;
    private $firstName;
    private $lastName;
    private $displayName;
    private $email;
    private $additionalEmails;
    private $notVerifiedEmails;
    private $admin;

    private $issuer;
    private $subject;
    private $name;

    public function __construct($jwtData) {
        if (isset($jwtData->app_metadata)) {
            $appData = $jwtData->app_metadata;
            if (isset($appData->identityId)) {
                $this->identityId = $appData->identityId;
                $this->firstName = isset($appData->firstName) ? $appData->firstName : null;
                $this->lastName = isset($appData->lastName) ? $appData->lastName : null;
                $this->displayName = isset($appData->displayName) ? $appData->displayName : null;
                $this->email = isset($appData->email) ? $appData->email : null;
                $this->additionalEmails = isset($appData->additionalEmails) ? $appData->additionalEmails : [];
                $this->notVerifiedEmails = isset($appData->notVerifiedEmails) ? $appData->notVerifiedEmails : [];
                $this->admin = isset($appData->admin) ? ($appData->admin ? true : false) : false;
            } else {
                throw new \InvalidArgumentException('Not a cerpus identity token');
            }
        } else {
            throw new \InvalidArgumentException('Not a cerpus identity token');
        }

        $this->issuer = isset($jwtData->iss) ? $jwtData->iss : null;
        $this->subject = isset($jwtData->sub) ? $jwtData->sub : null;
        $this->name = isset($jwtData->name) ? $jwtData->name : null;
    }

    public function getIdentityId() : string {
        return $this->identityId;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getDisplayName() {
        return $this->displayName;
    }

    public function getEmail() {
        return $this->email;
    }

   public function getAdditionalEmails(): array {
        return $this->additionalEmails;
    }

    public function getNotVerifiedEmails(): array {
        return $this->notVerifiedEmails;
    }

    public function isAdmin(): bool {
        return $this->admin;
    }

    public function getIssuer() {
        return $this->issuer;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function getName() {
        return $this->name;
    }
}