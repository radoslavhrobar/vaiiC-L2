<?php

namespace App\Controllers;

use App\Helpers\TypesOfWork;
use App\Models\BookDetail;
use App\Models\Country;
use App\Models\FavoriteWork;
use App\Models\Genre;
use App\Models\MovieDetail;
use App\Models\Review;
use App\Models\SeriesDetail;
use App\Models\User;
use App\Models\Work;
use DateTime;
use Framework\Core\BaseController;
use Framework\Core\Model;
use Framework\Core\Router;
use Framework\DB\Connection;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use Framework\Support\LinkGenerator;

class WorkController extends BaseController
{

    public function index(Request $request): Response
    {
        return $this->html();
    }

    public function rankings(Request $request): Response {
        $types = TypesOfWork::cases();
        $sql = self::getBaseSqlForRankedWorks();
        $ok = true;
        $params = [];
        $page = $request->value('page');
        $get = true;
        $genres = Genre::getAll();
        if ($page) {
            $data = $request->get();
        } else {
            $data = $request->post();
            if ($data) {
                $genres = $this->chooseGenres($data['type'] ?? '');
            }
            $get = false;
        }
        if (($get && count($data) > 3) || (!$get && $data)) {
            if (!isset($data['type'], $data['genre'], $data['yearTo'], $data['yearFrom'], $data['order'])) {
                throw new \Exception('Nedostatočné údaje pre filtrovanie.');
            }
            if (!$this->checkRankings($data)) {
                $ok = false;
                return $this->html(compact('genres', 'types', 'ok') );
            }
            $where = ['w.date_of_issue BETWEEN ? AND ?'];
            $params = [
                $data['yearFrom'] . '-01-01',
                $data['yearTo'] . '-12-31'
            ];

            if ($data['type'] !== 'všetky') {
                $where[] = 'w.type = ?';
                $params[] = $data['type'];
            }

            if ($data['genre'] !== 'všetky') {
                $where[] = 'w.genre_id = ?';
                $params[] = $data['genre'];
            }

            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= ' GROUP BY w.id, w.name, w.type, w.date_of_issue, g.name, c.name';
        $orderBy = $this->whichOrderBy($data['order'] ?? '');
        $sql .= ' ORDER BY ' . $orderBy;
        $works = self::executeDatabase($sql, $params);

        $perPage = 10;
        $currentPage = isset($page) ? (int)$page : 1;
        $totalWorks = count($works);
        $totalPages = ceil((float)$totalWorks / $perPage);
        $start = ($currentPage - 1) * $perPage;
        $worksToShow = array_slice($works, $start, $perPage);
        return $this->html(compact('genres', 'types', 'works', 'ok', 'worksToShow', 'currentPage', 'totalPages', 'start'));
    }

    public static function executeDatabase($sql, $params) : array {
        $stmt = Connection::getInstance()->prepare($sql);
        $stmt->execute($params ?? null);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getBaseSqlForRankedWorks() : string {
        return '
            SELECT 
                w.id, w.name, w.type, w.date_of_issue, w.description, w.image,
                g.name AS genre, c.name AS country, 
                AVG(r.rating) AS avg_rating, 
                COUNT(r.rating) AS rating_count, 
                COUNT(fw.work_id) AS favorites_count
            FROM works w
            JOIN countries c ON w.place_of_issue_id = c.id
            JOIN genres g ON w.genre_id = g.id
            LEFT JOIN reviews r ON r.work_id = w.id
            LEFT JOIN favoriteworks fw ON fw.work_id = w.id
        ';
    }

    public function whichOrderBy($order) : string{
        return match ($order) {
            'worst' => 'avg_rating ASC',
            'favorite' => 'favorites_count DESC',
            'newest' => 'w.date_of_issue DESC',
            default => 'avg_rating DESC',
        };
    }

    public function ajaxCheckTypeOfWork(Request $request): Response
    {
        $type = $request->value('type');
        $genres = $this->chooseGenres($type);
        $yearFrom = TypesOfWork::getYear($type);
        return $this->json([
            'genres' => array_map(fn($g) => [
                'id' => $g->getId(),
                'name' => $g->getName()
            ], $genres)
         ,'yearFrom' => $yearFrom]);
    }

    public function ajaxSearchWorks(Request $request): Response
    {
        $text = $request->value('text');
        $works = Work::getAll(whereClause: '`name` LIKE ?', whereParams: ["%$text%"], orderBy: '`name`', limit: 10);
        return $this->json([
            'works' => array_map(fn($w) => [
                'url' => $w->getType() === 'Kniha' ? $this->url('bookDetail.page', ['id' => $w->getId()]) :
                    ($w->getType() === 'Film' ? $this->url('movieDetail.page', ['id' => $w->getId()]) :
                        $this->url('seriesDetail.page', ['id' => $w->getId()])),
                'year' => (new DateTime($w->getDateOfIssue()))->format('Y'),
                'name' => $w->getName(),
                'type' => $w->getType(),
            ], $works)
        ]);
    }

    public function ajaxUpdateFav(Request $request): Response
    {
        $id = (int)$request->value('workId');
        $work = Work::getOne($id);
        if (empty($work)) {
            throw new \Exception('Dielo neexistuje.');
        }
        $user = $this->app->getAuth()->getUser();
        if (empty($user)) {
            throw new \Exception('Používateľ nie je prihlásený.');
        }
        $isFavorite = $this->isFavorite($work, $user);
        if ($isFavorite) {
            $isFav = FavoriteWork::getAll(whereClause: '(`user_id` = ? AND `work_id` = ?)', whereParams: [$user->getId(), $work->getId()]);
            $isFav[0]->delete();
            return $this->json(['adding' => false]);
        }
        $favWork = new FavoriteWork();
        $favWork->setUserId($user->getId());
        $favWork->setWorkId($work->getId());
        $favWork->save();
        return $this->json(['adding' => true]);
    }

    public function chooseGenres(string $typeOfWork): array
    {
       return match ($typeOfWork) {
            'Film', 'Seriál' => Genre::getAll(whereClause: '(`type` = ? OR `type` = ?)', whereParams: ['Kino', 'Obidva']),
            'Kniha' => Genre::getAll(whereClause: '(`type` = ? OR `type` = ?)', whereParams: ['Kniha', 'Obidva']),
            'všetky' => Genre::getAll(),
            default => throw new \Exception('Neplatný typ diela.')
        };
    }
    public function initialPage(Request $request): array
    {
        $id = $request->value('id');
        $work = Work::getOne($id);
        if (empty($work)) {
            throw new \Exception('Dielo neexistuje.');
        }
        $genreByWorkId = Genre::getOne($work->getGenre());
        $countryByWorkId = Country::getOne($work->getPlaceOfIssue());
        $reviews = Review::getAll('work_id = ?', [$work->getId()], 'created_at DESC');
        $avgRating = $this->getAverageRating($reviews)/5*100;
        $reviewsFiltered  = Review::getAll('(`work_id` = ? AND `body` IS NOT NULL)', [$work->getId()], 'created_at DESC');
        $users = $this->getUsersByIds($reviewsFiltered);
        $myReview = null;
        $hasReview = $this->hasReview($reviews, $this->app->getAuth()->getUser(), $myReview);
        $isFavorite  = $this->isFavorite($work, $this->app->getAuth()->getUser());
        $text = $request->value('text');
        $color = $request->value('color');
        return compact('work', 'genreByWorkId', 'countryByWorkId', 'reviews', 'reviewsFiltered', 'users', 'hasReview', 'myReview', 'text', 'color', 'isFavorite', 'avgRating');
    }

    public function getAverageRating($reviews): float {
        if (count($reviews) === 0) {
            return 0;
        }
        $sum = 0;
        foreach ($reviews as $review) {
            $sum += $review->getRating();
        }
        return round($sum / count($reviews), 2);
    }

    public function isFavorite(Work $work, ?User $user): bool {
        if (!$user) {
            return false;
        }
        $isFav = FavoriteWork::getAll(whereClause: '(`user_id` = ? AND `work_id` = ?)', whereParams: [$user->getId(), $work->getId()]);
        if (count($isFav) === 1) {
            return true;
        }
        return false;
    }

    public function getUsersByIds(array $reviews) : array {
        $users = [];
        foreach ($reviews as $i => $review) {
            $users[$i] = User::getOne($review->getUserId());
        }
        return $users;
    }

    public function hasReview(array $reviews, ?User $user, ?Review &$myReview): bool
    {
        if (!$user) {
            return true;
        }
        foreach ($reviews as $review) {
            if ($review->getUserId() === $user->getId()) {
                $myReview = $review;
                return true;
            }
        }
        return false;
    }

    public function workAdd($d, $file, string $type): Work
    {
        $work = new Work();
        $work->setName(trim($d['workName']));
        $work->setType($type);
        $work->setGenre($d['genre']);
        $work->setDateOfIssue($d['dateOfIssue']);
        $work->setPlaceOfIssue($d['placeOfIssue']);
        $work->setDescription(trim($d['description']));
        $uploadDir = __DIR__ . '/../../public/uploads/works';
        $filename = uniqid() . '-' . $file->getName();
        $file->store($uploadDir . '/' . $filename);
        $work->setImage($filename);
        $work->save();
        return $work;
    }

    public function workEdit($d, $file, Work $work): void
    {
        $work->setName(trim($d['workName']));
        $work->setGenre($d['genre']);
        $work->setDateOfIssue($d['dateOfIssue']);
        $work->setPlaceOfIssue($d['placeOfIssue']);
        $work->setDescription(trim($d['description']));
        $work->save();
    }

    public function changeImage(Work $work, $file): void
    {
        $uploadDir = __DIR__ . '/../../public/uploads/works';
        $filename = uniqid() . '-' . $file->getName();
        $file->store($uploadDir . '/' . $filename);
        $old = $work->getImage();
        if (file_exists($uploadDir . '/' . $old)) {
            unlink($uploadDir . '/' . $old);
        }
        $work->setImage($filename);
    }

    public function form(Request $request) : Response
    {
        return $this->html();
    }
    public function check($data, $file): bool
    {
        if (!$this->checkWorkName($data['workName']) || !$this->checkGenre($data['genre']) ||
            !$this->checkPlaceOfIssue($data['placeOfIssue']) || !$this->checkDescription($data['description'])) {
            return false;
        }
        return true;
    }

    public function checkRankings($data) : bool {
        if (($this->checkType($data['type']) || $data['type'] === 'všetky') && ($this->checkGenre($data['genre']) || $data['genre'] === 'všetky') &&
            $this->checkYearFrom($data['yearFrom'], $data['type']) && $this->checkYearTo($data['yearTo'], $data['yearFrom'], $data['type']) && $this->checkOrderBy($data['order'])) {
            return true;
        }
        return false;
    }

    public function checkWorkName(string $workName): bool
    {
        $workName = trim($workName);
        if (empty($workName) || (mb_strlen($workName) < 2 || mb_strlen($workName) > 255) ||  !preg_match('/^[\p{Lu}0-9]$/u', mb_substr($workName, 0, 1, 'UTF-8'))) {
            return false;
        }
        if (!preg_match('/^[\p{L}0-9 :.,&?\'\-]+$/u', $workName)) {
            return false;
        }
        return true;
    }

    public function checkGenre(string $id): bool
    {
        if (empty($id)) {
            return false;
        }
        $genre = Genre::getOne((int)$id);
        if (empty($genre)) {
            return false;
        }
        return true;
    }

    public function  checkDateOfIssue(string $date, string $limit): bool
    {
        if (empty($date) || !strtotime($date) || $date > date('Y-m-d') || $date < "$limit-01-01") {
            return false;
        }
        return true;
    }

    public function checkPlaceOfIssue(string $id): bool
    {
        if (empty($id)) {
            return false;
        }
        $country = Country::getOne((int)$id);
        if (empty($country)) {
            return false;
        }
        return true;
    }

    public function checkDescription(string $description): bool
    {
        $description = trim($description);
        if (empty($description) || (mb_strlen($description) < 3 || mb_strlen($description) > 1000) || !preg_match('/^[\p{Lu}0-9]$/u', mb_substr($description, 0, 1, 'UTF-8'))) {
            return false;
        }
        return true;
    }

    public function checkType(string $type): bool
    {
        if (empty($type) || !in_array($type, array_map(fn($t) => $t->name, TypesOfWork::cases()))) {
            return false;
        }
        return true;
    }

    public function checkYearFrom(string $yearFrom, string $type) : bool{
        $limitYear = TypesOfWork::getYear($type);
        if (empty($yearFrom) || !is_numeric($yearFrom) || (int)$yearFrom < (int)$limitYear || (int)$yearFrom > 2026) {
            return false;
        }
        return true;
    }

    public function checkYearTo(string $yearTo, string $yearFrom, string $type) : bool {
        $limitYear = TypesOfWork::getYear($type);
        if (empty($yearTo) || !is_numeric($yearTo) || (int)$yearTo < (int)$limitYear || (int)$yearTo > 2026 || (int)$yearTo < (int)$yearFrom) {
            return false;
        }
        return true;
    }

    public function checkOrderBy($order): bool
    {
        return in_array($order, ['best', 'worst', 'favorite', 'newest']);
    }

    public function checkImage($file): bool
    {
        $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($file->getType(), $allowedTypes)) {
            return false;
        }
        $maxFileSize = 5 * 1024 * 1024;
        if ($file->getSize() > $maxFileSize) {
            return false;
        }
        return true;
    }

    public function checkImageError($file) : string|null {
        return $file->getErrorMessage();
    }

    public function checkImageFull($file, $data) : array
    {
        $error = $this->checkImageError($file);
        if ($error) {
            return compact('error') +  $data;
        }
        if (!$this->checkImage($file)) {
            $text = 'Filmové údaje obsahujú chyby.';
            $color = 'danger';
            return compact('text', 'color') +  $data;
        }
        return [];
    }
}