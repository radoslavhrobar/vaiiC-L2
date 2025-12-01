<?php

namespace App\Controllers;

use App\Configuration;
use App\Helpers\Gender;
use App\Models\User;
use Exception;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\ViewResponse;

/**
 * Class AuthController
 *
 * This controller handles authentication actions such as login, logout, and redirection to the login page. It manages
 * user sessions and interactions with the authentication system.
 *
 * @package App\Controllers
 */
class AuthController extends BaseController
{
    /**
     * Redirects to the login page.
     *
     * This action serves as the default landing point for the authentication section of the application, directing
     * users to the login URL specified in the configuration.
     *
     * @return \Framework\Http\Responses\Response The response object for the redirection to the login page.
     */
    public function index(Request $request): Response
    {
        return $this->redirect(Configuration::LOGIN_URL);
    }

    /**
     * Authenticates a user and processes the login request.
     *
     * This action handles user login attempts. If the login form is submitted, it attempts to authenticate the user
     * with the provided credentials. Upon successful login, the user is redirected to the admin dashboard.
     * If authentication fails, an error message is displayed on the login page.
     *
     * @return Response The response object which can either redirect on success or render the login view with
     *                  an error message on failure.
     * @throws Exception If the parameter for the URL generator is invalid throws an exception.
     */
    public function login(Request $request): Response
    {
        $logged = null;
        if ($request->hasValue('submit')) {
            $logged = $this->app->getAuth()->login($request->value('username'), $request->value('password'));
            if ($logged) {
                return $this->redirect($this->url("home.index"));
            }
        }

        $message = $logged === false ? 'Nesprávne používateľské meno alebo heslo.' : null;
        return $this->html(compact("message"));
    }

    /**
     * Logs out the current user.
     *
     * This action terminates the user's session and redirects them to a view. It effectively clears any authentication
     * tokens or session data associated with the user.
     *
     * @return ViewResponse The response object that renders the logout view.
     */
    public function logout(Request $request): Response
    {
        $this->app->getAuth()->logout();
        return $this->redirect($this->url("home.index"));
    }

    public function registration(Request $request): Response
    {
        return $this->html();
    }

    public function register(Request $request): Response
    {
        $d = $request->post();
        if ($this->checkRegistration($d)) {
            $user = new User();
            $user->setEmail($d['email']);
            $user->setUsername($d['username']);
            $user->setPassword($d['password']);
            if (!empty($d['name'])) {
                $user->setName($d['name']);
            }
            if (!empty($d['surname'])) {
                $user->setSurname($d['surname']);
            }
            if (!empty($d['gender'])) {
                $user->setGender($d['gender']);
            }
            $user->save();
            return $this->redirect($this->url('home.index'));
        }
        $message = 'Formulárové údaje obsahujú chyby.';
        return $this->html(compact('message'), 'registration');
    }

    public function edit(Request $request): Response
    {
        return $this->html();
    }

    public function checkRegistration($data): bool
    {
        $check = true;
        if (!$this->checkRegistrationEmail($data['email']) || !$this->checkRegistrationUsername($data['username']) ||
            !$this->checkRegistrationPassword($data['password']) || !$this->checkRegistrationVerifyPassword($data['verifyPassword'], $data['password']) ||
            !$this->checkRegistrationPersonal($data['name']) ||  !$this->checkRegistrationPersonal($data['surname']) || !$this->checkRegistrationGender($data['gender'])) {
            $check = false;
        }
        return $check;
    }

    public function checkRegistrationEmail(string $email): bool
    {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || User::getAll(whereClause: '`email` = ?', whereParams: [$email])) {
            return false;
        }
        return true;
    }

    public function checkRegistrationUsername(string $username): bool
    {
        if (empty($username) || (strlen($username) < 3 || strlen($username) > 30)) {
            return false;
        }
        if (is_numeric($username[0]) || !ctype_alnum($username) || User::getAll(whereClause: '`username` = ?', whereParams: [$username])) {
            return false;
        }
        return true;
    }

    public function checkRegistrationPassword(string $password): bool
    {
        if (empty($password) || strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password)) {
            return false;
        }
        if (!preg_match('/[0-9]/', $password) || !preg_match('/[!@#$%^&*]/', $password)) {
            return false;
        }
        return true;
    }

    public function checkRegistrationVerifyPassword(string $verifyPassword, string $password): bool
    {
        if (empty($verifyPassword) || $verifyPassword !== $password) {
            return false;
        }
        return true;
    }

    public function checkRegistrationPersonal(string $personal): bool
    {
        if (empty($personal)) {
            return true;
        }
        if (strlen($personal) > 80 || !preg_match('/^[a-zA-ZáäčďéëíĺľňóöôřšťúüýžÁÄČĎÉËÍĹĽŇÓÖÔŘŠŤÚÜÝŽ]+$/u', $personal) || !ctype_upper($personal[0])) {
            return false;
        }
        return true;
    }

    public function checkRegistrationGender(string $gender): bool
    {
        if (empty($gender)) {
            return true;
        }
        $genders = array_map(fn($g) => $g->name, Gender::cases());
        if (!in_array($gender, $genders)) {
            return false;
        }
        return true;
    }
}
