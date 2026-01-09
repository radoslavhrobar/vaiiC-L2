<?php

namespace App\Controllers;

use App\Helpers\TypesOfWork;
use App\Models\BookDetail;
use App\Models\Country;
use App\Models\Genre;
use App\Models\MovieDetail;
use App\Models\Review;
use App\Models\SeriesDetail;
use App\Models\User;
use App\Models\Work;
use Framework\Core\BaseController;
use Framework\Core\Model;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class WorkController extends BaseController
{

    public function index(Request $request): Response
    {
        return $this->html();
    }

    public function rankings(Request $request): Response {
        $data = $request->post();
        $genres = Genre::getAll();
        $types = TypesOfWork::cases();
        $works = Work::getAll(orderBy: '`name`');
        $workDetails = $this->getMultipleWorkDetails($works);
        if ($data) {
            if (!isset($data['type'], $data['genre'], $data['yearTo'], $data['yearFrom'])) {
                throw new \Exception('Nedostatočné údaje pre filtrovanie.');
            }
            if ($data['type'] === 'všetky' && $data['genre'] === 'všetky') {
                $works = Work::getAll(
                    whereClause: '`date_of_issue` BETWEEN ? AND ?',
                    whereParams: [
                        $data['yearFrom'] . '-01-01',
                        $data['yearTo'] . '-12-31'
                    ],
                    orderBy: '`name`'
                );
                $workDetails = $this->getMultipleWorkDetails($works);
            } else if ($data['type'] === 'všetky' && $data['genre'] !== 'všetky') {
                $works = Work::getAll(
                    whereClause: '`genre_id` = ? AND `date_of_issue` BETWEEN ? AND ?',
                    whereParams: [
                        $data['genre'],
                        $data['yearFrom'] . '-01-01',
                        $data['yearTo'] . '-12-31'
                    ],
                    orderBy: '`name`'
                );
                $workDetails = $this->getMultipleWorkDetails($works);
            } else if ($data['genre'] === 'všetky') {
                $works = Work::getAll(
                    whereClause: '`type` = ? AND `date_of_issue` BETWEEN ? AND ?',
                    whereParams: [
                        $data['type'],
                        $data['yearFrom'] . '-01-01',
                        $data['yearTo'] . '-12-31'
                    ],
                    orderBy: '`name`'
                );
                $workDetails = $this->getWorkDetails($works, $data['type']);
            } else {
                $works = Work::getAll(
                    whereClause: '`type` = ? AND `genre_id` = ? AND `date_of_issue` BETWEEN ? AND ?',
                    whereParams: [
                        $data['type'],
                        $data['genre'],
                        $data['yearFrom'] . '-01-01',
                        $data['yearTo'] . '-12-31'
                    ],
                    orderBy: '`name`'
                );
                $workDetails = $this->getWorkDetails($works, $data['type']);
            }
        }
        $genresByIds = $this->getGenresByIds($works);
        $countriesByIds = $this->getCountriesByIds($works);
        return $this->html(compact('genres', 'types', 'works', 'workDetails', 'genresByIds', 'countriesByIds'));
    }

    public function getWorkDetail(string $typeOfWork, string $id) : mixed {
        return match ($typeOfWork) {
            'Film' => MovieDetail::getOne($id),
            'Seriál' => SeriesDetail::getOne($id),
            'Kniha' => BookDetail::getOne($id),
            default => throw new \Exception('Neznámy typ diela.'),
        };
    }

    public function getWorkDetails(array $works, string $typeOfWork): array
    {
        $workDetails = [];
        switch ($typeOfWork) {
            case 'Film':
                foreach ($works as $i => $work) {
                    $workDetails[$i] = MovieDetail::getOne($work->getId());
                }
                break;
            case 'Seriál':
                foreach ($works as $i => $work) {
                    $workDetails[$i] = SeriesDetail::getOne($work->getId());
                }
                break;
            case 'Kniha':
                foreach ($works as $i => $work) {
                    $workDetails[$i] = BookDetail::getOne($work->getId());
                }
                break;
            default:
                throw new \Exception('Neznámy typ diela.');
        }
        return $workDetails;
    }

    public function getMultipleWorkDetails(array $works): array
    {
        $workDetails = [];
        foreach ($works as $i => $work) {
            $workDetails[$i] = $this->getWorkDetail($work->getType(), $work->getId());
        }
        return $workDetails;
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

    public function chooseGenres(string $typeOfWork): array
    {
       return match ($typeOfWork) {
            'Film', 'Seriál' => Genre::getAll(whereClause: '(`type` = ? OR `type` = ?)', whereParams: ['Kino', 'Obidva']),
            'Kniha' => Genre::getAll(whereClause: '(`type` = ? OR `type` = ?)', whereParams: ['Kniha', 'Obidva']),
            'všetky' => Genre::getAll(),
            default => [],
        };
    }
    public function ownPage(Request $request): Response
    {
        $id = $request->value('id');
        $work = Work::getOne($id);
        if (empty($work)) {
            throw new \Exception('Dielo neexistuje.');
        }
        $genreByWorkId = Genre::getOne($work->getGenre());
        $countryByWorkId = Country::getOne($work->getPlaceOfIssue());
        $movieDetail = null;
        $seriesDetail = null;
        $bookDetail = null;
        if ($work->getType() === 'Film') {
            $movieDetail = MovieDetail::getOne($work->getId());
        } elseif ($work->getType() === 'Seriál') {
            $seriesDetail = SeriesDetail::getOne($work->getId());
        } else if ($work->getType() === 'Kniha') {
            $bookDetail = BookDetail::getOne($work->getId());
        }
        $reviews = Review::getAll('work_id = ?', [$work->getId()], 'created_at DESC');
        $reviewsFiltered  = Review::getAll('(`work_id` = ? AND `body` IS NOT NULL)', [$work->getId()], 'created_at DESC');
        $users = $this->getUsersByIds($reviewsFiltered);
        $myReview = null;
        $hasReview = $this->hasReview($reviews, $this->app->getAuth()->getUser(), $myReview);
        $text = $request->value('text');
        $color = $request->value('color');
        return $this->html(compact('work', 'genreByWorkId', 'countryByWorkId', 'movieDetail', 'seriesDetail', 'bookDetail', 'reviews', 'users', 'hasReview', 'reviewsFiltered', 'myReview', 'text', 'color'));
    }

    public function getCountriesByIds(array $works) : array {
        $countries = [];
        foreach ($works as $i => $work) {
            $countries[$i] = Country::getOne($work->getPlaceOfIssue());
        }
        return $countries;
    }

    public function getGenresByIds(array $works) : array {
        $genres = [];
        foreach ($works as $i => $work) {
            $genres[$i] = Genre::getOne($work->getGenre());
        }
        return $genres;
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

    public function workAdd($d, string $type): Work
    {
        $work = new Work();
        $work->setName(trim($d['workName']));
        $work->setType($type);
        $work->setGenre($d['genre']);
        $work->setDateOfIssue($d['dateOfIssue']);
        $work->setPlaceOfIssue($d['placeOfIssue']);
        $work->setDescription(trim($d['description']));
        $work->save();
        return $work;
    }

    public function form(Request $request) : Response
    {
        return $this->html();
    }
    public function check($data): bool
    {
        if (!$this->checkWorkName($data['workName']) || !$this->checkGenre($data['genre']) ||
            !$this->checkPlaceOfIssue($data['placeOfIssue']) || !$this->checkDescription($data['description'])) {
            return false;
        }
        return true;
    }

    public function checkWorkName(string $workName): bool
    {
        $workName = trim($workName);
        if (empty($workName) || (mb_strlen($workName) < 2 || mb_strlen($workName) > 255) ||  !preg_match('/^\p{Lu}$/u', mb_substr($workName, 0, 1, 'UTF-8'))) {
            return false;
        }
        if (!preg_match('/^[a-zA-ZáäčďéëíĺľňóöôřšťúüýžÁÄČĎÉËÍĹĽŇÓÖÔŘŠŤÚÜÝŽ0-9 :,.\'-]+$/u', $workName)) {
            return false;
        }
        return true;
    }

    public function checkGenre(string $id): bool
    {
        if (empty($id)) {
            return false;
        }
        $genre = Genre::getOne($id);
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
        $country = Country::getOne($id);
        if (empty($country)) {
            return false;
        }
        return true;
    }

    public function checkDescription(string $description): bool
    {
        $description = trim($description);
        if (empty($description) || (mb_strlen($description) < 3 || mb_strlen($description) > 1000) || !preg_match('/^\p{Lu}$/u', mb_substr($description, 0, 1, 'UTF-8'))) {
            return false;
        }
        return true;
    }
}