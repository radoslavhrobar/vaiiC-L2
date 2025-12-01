<?php

namespace Framework\Auth;

use Framework\Core\IAuthenticator;
use Framework\Core\IIdentity;

class Authenticator implements IAuthenticator
{

    public function login(string $username, string $password): bool
    {
       
    }

    public function logout(): void
    {
        // TODO: Implement logout() method.
    }

    public function isLogged(): bool
    {
        // TODO: Implement isLogged() method.
    }

    public function getUser(): ?IIdentity
    {
        // TODO: Implement getUser() method.
    }
}