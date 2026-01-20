<?php

namespace Framework\Auth;

use App\Models\User;
use Framework\Core\App;
use Framework\Core\IAuthenticator;
use Framework\Core\IIdentity;
use Framework\Http\Session;

class Authenticator implements IAuthenticator
{
    private App $app;
    private Session $session;
    private ?IIdentity $user = null;
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->session = $this->app->getSession();
    }

    public function login(string $username, string $password): bool
    {
        $users = User::getAll(whereClause: '`username` = ?', whereParams: [$username]);
        $user = $users[0] ?? null;
        if ($user && password_verify($password, $user->getPassword())) {
            $this->user = $user;
            $this->session->set('user_id', $user->getId());
            return true;
        }
        return false;
    }

    public function logout(): void
    {
        $this->user = null;
        $this->session->destroy();
    }

    public function isLogged(): bool
    {
        return $this->getUser() instanceof IIdentity;
    }

    public function getUser(): ?IIdentity
    {
        if ($this->user instanceof IIdentity) {
            return $this->user;
        }

        $userId = $this->session->get('user_id');
        if (!$userId) {
            return null;
        }

        $records = User::getAll(whereClause: '`id` = ?', whereParams: [$userId]);
        $this->user = $records[0] ?? null;
        return $this->user instanceof IIdentity ? $this->user : null;
    }
}