<?php

namespace App\Controllers;

use App\Configuration;
use App\Helpers\Gender;
use App\Helpers\Role;
use App\Models\FavoriteWork;
use App\Models\Review;
use App\Models\User;
use App\Models\Work;
use Exception;
use Framework\Core\BaseController;
use Framework\Core\Model;
use Framework\DB\Connection;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\JsonResponse;
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
    public function authorize(Request $request, string $action): bool
    {
        return match ($action) {
            'index', 'login', 'registration', 'register', 'ajaxCheckEmail',
            'ajaxCheckUsername', 'all', 'page' => true,
            'delete' => $this->checkAdmin(),
            'edit', 'update', 'deleteYourself', 'ajaxCheckCurrentPassword', 'logout' => $this->app->getAuth()->isLogged(),
            default => false,
        };
    }
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
        $text = 'Úspešne ste sa odhlásili.';
        $color = 'success';
        return $this->redirect($this->url("home.index", ['text' => $text, 'color' => $color]));
    }

    public function registration(Request $request): Response
    {
        return $this->html();
    }

    public function register(Request $request): Response
    {
        $d = $request->post();
        $text = 'Úspešná registrácia!';
        $color = 'success';
        if ($this->check($d, false)) {
            $user = new User();
            $user->setEmail($d['email']);
            $user->setUsername($d['username']);

            $hashedPassword = password_hash($d['password'], PASSWORD_DEFAULT);
            $user->setPassword($hashedPassword);

            if (!empty($d['name'])) {
                $user->setName($d['name']);
            }
            if (!empty($d['surname'])) {
                $user->setSurname($d['surname']);
            }
            if (!empty($d['gender'])) {
                $user->setGender($d['gender']);
            }
            $user->setCreatedAt(date('Y-m-d H:i:s'));
            $user->save();
            return $this->html(compact('text', 'color') , 'login');
        }
        $text = 'Formulárové údaje obsahujú chyby.';
        $color = 'danger';
        return $this->html(compact('text', 'color'), 'registration');
    }

    public function edit(Request $request): Response
    {
        $user = $this->app->getAuth()->getUser();
        return $this->html(compact('user'));
    }

    public function update(Request $request): Response
    {
        $id = (int)$request->value('id');
        if ($this->app->getAuth()->getUser()->getId() !== $id) {
            throw new HttpException(403, "Nemáte oprávnenie na úpravu tohto používateľa.");
        }
        $user = User::getOne($id);
        if (!$user) {
            throw new Exception("Používateľ nenájdený.");
        }
        $d = $request->post();
        $text = 'Údaje boli úspešne aktualizované.';
        $color = 'success';
        if ($this->check($d, true)) {
            $user->setEmail($d['email']);
            $user->setUsername($d['username']);
            if (!empty($d['password'])) {
                $hashedPassword = password_hash($d['password'], PASSWORD_DEFAULT);
                $user->setPassword($hashedPassword);
            }
            if (empty($d['name'])) {
                $user->setName(null);
            } else {
                $user->setName($d['name']);
            }
            if (empty($d['surname'])) {
                $user->setSurname(null);
            } else {
                $user->setSurname($d['surname']);
            }
            if (empty($d['gender'])) {
                $user->setGender(null);
            } else {
                $user->setGender($d['gender']);
            }
            $user->save();
        } else {
            $text = 'Formulárové údaje obsahujú chyby.';
            $color = 'danger';
        }
        return $this->html(compact( 'text','color'), 'edit');
    }

    public function delete(Request $request): Response
    {
        $id = (int)$request->value('id');
        $target = User::getOne($id);
        if (!$target) {
            throw new Exception("Cieľový používateľ nenájdený.");
        }
        $this->deleteOther($target);
        $target->delete();
        $text = 'Používateľ bol úspešne zmazaný.';
        $color = 'success';
        return $this->redirect($this->url("auth.all", ['text' => $text, 'color' => $color]));
    }

    public function deleteYourself(Request $request): Response
    {
        $user = $this->app->getAuth()->getUser();
        $this->deleteOther($user);
        $user->delete();
        $this->app->getAuth()->logout();
        $text = 'Váš účet bol úspešne zmazaný.';
        $color = 'success';
        return $this->redirect($this->url("home.index", ['text' => $text, 'color' => $color]));
    }

    public function deleteOther($user): void
    {
        $favoriteWorks = FavoriteWork::getAll('user_id = ?', [$user->getId()]);
        foreach ($favoriteWorks as $fav) {
            $fav->delete();
        }
        $reviews = Review::getAll('user_id = ?', [$user->getId()]);
        foreach ($reviews as $rev) {
            $rev->delete();
        }
    }

    public function all(Request $request): Response
    {
        $text = $request->hasValue('text') ? $request->value('text') : null;
        $color = $request->hasValue('color') ? $request->value('color') : null;
        $data = $this->getUsersReviewRatingFavCounts();
        $isAdmin = $this->checkAdmin();
        return $this->html(compact('isAdmin', 'data', 'text', 'color'));
    }

    public function page(Request $request): Response
    {
        if (!$request->hasValue('id')) {
            $id = $this->app->getAuth()->getUser()?->getId();
        } else {
            $id = (int)$request->value('id');
        }
        $user = User::getOne($id);
        if (!$user) {
            throw new Exception("Používateľ nenájdený.");
        }

        $favGenres = $this->getFavoriteGenres($user->getId());
        if (!empty(array_column($favGenres, 'count'))) {
            $maxCount = max(array_column($favGenres, 'count'));
        } else {
            $maxCount = 0;
        }
        $percentages = $this->calculatePercentages($favGenres, $maxCount);
        $whichActive = $request->hasValue('tab') ? $request->value('tab') : 'reviews';

        if ($request->hasValue('tab') && $request->value('tab') === 'ratings') {
            $worksRatings = $this->getWorksRatings($user->getId());
            return $this->html(compact('user', 'favGenres', 'percentages', 'whichActive', 'worksRatings'), 'ratingSection');
        } elseif ($request->hasValue('tab') && $request->value('tab') === 'favorites') {
            $favoriteWorks = $this->getFavoriteWorks($user->getId());
            return $this->html(compact('user', 'favGenres', 'percentages', 'whichActive', 'favoriteWorks'), 'favSection');
        }
        $worksReviews = $this->getWorksReviews($user->getId());
        $text = $request->hasValue('text') ? $request->value('text') : null;
        $color = $request->hasValue('color') ? $request->value('color') : null;
        return $this->html(compact('user', 'favGenres', 'percentages', 'whichActive', 'worksReviews', 'text', 'color'), 'reviewSection');
    }

    public function getFavoriteGenres($userId): array {
        $sql  = '
            SELECT g.name, count(*) AS count
            FROM favoriteworks fw
            JOIN works w ON fw.work_id = w.id
            JOIN genres g ON w.genre_id = g.id
            WHERE fw.user_id = ?
            GROUP BY g.id
            ORDER BY count DESC
            LIMIT 3
            ';
        $stmt = Connection::getInstance()->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getWorksReviews($userId): array {
        $sql  = '
            SELECT w.name, w.id, w.date_of_issue, w.type, r.rating, r.body, r.created_at, r.updated_at, r.id as review_id
            FROM reviews r
            JOIN works w ON r.work_id = w.id
            WHERE r.user_id = ?
            AND r.body IS NOT NULL
            ORDER BY COALESCE(r.updated_at, r.created_at) DESC
            ';
        $stmt = Connection::getInstance()->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getWorksRatings($userId): array {
        $sql  = '
            SELECT w.name, w.id, w.date_of_issue, w.type, r.rating, r.created_at, r.updated_at
            FROM reviews r
            JOIN works w ON r.work_id = w.id
            WHERE r.user_id = ?
            ORDER BY COALESCE(r.updated_at, r.created_at) DESC
            ';
        $stmt = Connection::getInstance()->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getFavoriteWorks($userId): array {
        $sql  = '
            SELECT w.name, w.id, w.type, w.image
            FROM favoriteworks fw
            JOIN works w ON fw.work_id = w.id
            WHERE fw.user_id = ?
            ';
        $stmt = Connection::getInstance()->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUsersReviewRatingFavCounts() : array {
        $sql = '
            SELECT u.id, u.username, u.name, u.surname, u.role,
                (SELECT COUNT(*) FROM reviews r WHERE r.user_id = u.id AND r.body IS NOT NULL) AS review_count,
                (SELECT COUNT(*) FROM reviews r WHERE r.user_id = u.id) AS rating_count,
                (SELECT COUNT(*) FROM favoriteworks fw WHERE fw.user_id = u.id) AS fav_count
            FROM users u
        ';
        if ($this->app->getAuth()->isLogged()) {
            $sql.= ' WHERE u.id != ? ';
            $params[] = $this->app->getAuth()->getUser()->getId();
        }
        $sql .= ' ORDER BY review_count DESC, rating_count DESC, fav_count DESC ';
        $stmt = Connection::getInstance()->prepare($sql);
        $stmt->execute($params ?? null);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function calculatePercentages($favGenres, $max) : array {
        $percentages = [];
        foreach ($favGenres as $i => $genre) {
            $percentages[$i] = ($max > 0) ? ($genre['count'] / $max) * 100 : 0;
        }
        return $percentages;
    }

    public function checkAdmin(): bool
    {
        $authUser = $this->app->getAuth()->getUser();
        if ($authUser && $authUser->getRole() === Role::Admin->name) {
            return true;
        }
        return false;
    }

    public function check($data, $optional): bool
    {
        $check = true;
        if (!$this->checkEmail($data['email'], $data['id'] ?? null) || !$this->checkUsername($data['username'], $data['id'] ?? null) ||
            !$this->checkPassword($data['password'], $optional) || !$this->checkVerifyPassword($data['verifyPassword'], $data['password'], $optional) ||
            !$this->checkPersonal($data['name']) ||  !$this->checkPersonal($data['surname']) || !$this->checkGender($data['gender'])) {
            $check = false;
        }
        if (isset($data['currentPassword'])) {
            $users = User::getAll(whereClause: '`password` = ?', whereParams: [$data['currentPassword']]);
            if (!empty($data['password']) && (empty($users) || !$this->checkForId($users, $data['id']))) {
                $check = false;
            }
        }
        return $check;
    }

    public function checkForId($users, int $id): bool
    {
        foreach ($users as $user) {
            if ($user->getId() === $id) {
                return true;
            }
        }
        return false;
    }

    public function checkEmail(string $email, ?int $currentUserId): bool
    {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $existing = User::getAll(whereClause: '`email` = ?', whereParams: [$email]);
        if (!empty($existing)) {
            if ($currentUserId === null || $existing[0]->getId() !== $currentUserId) {
                return false;
            }
        }
        return true;
    }

    public function checkUsername(string $username, ?int $currentUserId): bool
    {
        if (empty($username) || (mb_strlen($username) < 3 || mb_strlen($username) > 30)) {
            return false;
        }
        if (is_numeric($username[0]) || !ctype_alnum($username)) {
            return false;
        }
        $existing = User::getAll(whereClause: '`username` = ?', whereParams: [$username]);
        if (!empty($existing)) {
            if ($currentUserId === null || $existing[0]->getId() !== $currentUserId) {
                return false;
            }
        }
        return true;
    }

    public function checkPassword(string $password, bool $optional): bool
    {
        if (empty($password)) {
            if (!$optional) {
                return false;
            }
            return true;
        }
        if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password)) {
            return false;
        }
        if (!preg_match('/[0-9]/', $password) || !preg_match('/[!@#$%^&*]/', $password) || mb_strlen($password) < 8) {
            return false;
        }
        return true;
    }

    public function checkVerifyPassword(string $verifyPassword, string $password, bool $optional): bool
    {
        if (empty($verifyPassword)) {
            if ($optional && $password === "") {
                return true;
            }
            return false;
        }
        if ($verifyPassword !== $password) {
            return false;
        }
        return true;
    }

    public function checkPersonal(string $personal): bool
    {
        if (empty($personal)) {
            return true;
        }
        if (mb_strlen($personal) > 80 || !preg_match('/^[a-zA-ZáäčďéëíĺľňóöôřšťúüýžÁÄČĎÉËÍĹĽŇÓÖÔŘŠŤÚÜÝŽ]+$/u', $personal) || !ctype_upper($personal[0])) {
            return false;
        }
        return true;
    }

    public function checkGender(string $gender): bool
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

    public function ajaxCheckEmail(Request $request): Response
    {
        $email = $request->value('email');
        $id = (int)$request->value('id');
        $exists = false;
        $existing = User::getAll(whereClause: '`email` = ?', whereParams: [$email]);
        if (!empty($existing) && ($existing[0]->getId() !== $id)) {
            $exists = true;
        }
        return $this->json(['exists' => $exists]);
    }

    public function ajaxCheckUsername(Request $request): Response
    {
        $username = $request->value('username');
        $id = (int)$request->value('id');
        $exists = false;
        $existing = User::getAll(whereClause: '`username` = ?', whereParams: [$username]);
        if (!empty($existing) && ($existing[0]->getId() !== $id)) {
            $exists = true;
        }
        return $this->json(['exists' => $exists]);
    }
    public function ajaxCheckCurrentPassword(Request $request): Response
    {
        $currentPassword = $request->value('currentPassword');
        $id = (int)$request->value('id');
        $user = User::getOne($id);
        $exists = false;
        if ($user && password_verify($currentPassword, $user->getPassword())) {
            $exists = true;
        }
        return $this->json(['exists' => $exists]);
    }

}
