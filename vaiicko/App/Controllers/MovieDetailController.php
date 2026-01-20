<?php

namespace App\Controllers;

use App\Helpers\Role;
use App\Helpers\TypesOfWork;
use App\Models\Country;
use App\Models\Genre;
use App\Models\MovieDetail;
use App\Models\Work;
use Exception;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class MovieDetailController extends WorkController
{
    public function authorize(Request $request, string $action): bool
    {
        return match ($action) {
            'page' => true,
            'add', 'addMovie', 'edit', 'editMovie', 'delete'=> $this->app->getAuth()->isLogged() &&  $this->app->getAuth()->getUser()->getRole() === Role::Admin->name,
            default => false,
        };
    }
    public function index(Request $request): Response
    {
        return $this->html();
    }
    public function add(Request $request): Response
    {
        $data = $this->getData();
        return $this->html($data);
    }

    public function addMovie(Request $request): Response
    {
        $d = $request->post();
        $files = $request->file();
        if (!isset($d['workName'], $d['genre'], $d['dateOfIssue'], $d['placeOfIssue'], $d['description'], $files['image'], $d['movieLength'], $d['prodCompany'], $d['director'])) {
            throw new \Exception('Nedostatočné údaje pre pridanie filmu.');
        }
        $text = 'Film bol úspešne pridaný.';
        $color = 'success';
        $data = $this->getData();
        if ($this->check($d, $files['image'])) {
            $result = $this->checkImageFull($files['image'], $data);
            if (!empty($result)) {
                return $this->html($result, 'add');
            }
            $work = parent::workAdd($d, $files['image'], TypesOfWork::Film->name);
            $movieDetail = new MovieDetail();
            $movieDetail->setWorkId($work->getId());
            $movieDetail->setLength((int)$d['movieLength']);
            $movieDetail->setProdCompany(trim($d['prodCompany']));
            $movieDetail->setDirector(trim($d['director']));
            $movieDetail->save();
        } else {
            $text = 'Filmové údaje obsahujú chyby.';
            $color = 'danger';
        }
        return $this->html(compact('text', 'color') +  $data, 'add');
    }

    public function edit(Request $request): Response
    {
        $data = $this->checkForExistence($request);
        $data2 = $this->getData();
        return $this->html($data + $data2);
    }

    public function editMovie(Request $request): Response
    {
        $data = $this->checkForExistence($request);
        $d = $request->post();
        $files = $request->file();
        if (!isset($d['workName'], $d['genre'], $d['dateOfIssue'], $d['placeOfIssue'], $d['description'], $files['image'], $d['movieLength'], $d['prodCompany'], $d['director'])) {
            throw new \Exception('Nedostatočné údaje pre upravenie filmu.');
        }
        $text = 'Film bol úspešne upravený.';
        $color = 'success';
        $data2 = $this->getData();
        if ($this->check($d, $files['image'])) {
            $work = $data['work'];
            $movieDetail = $data['movieDetail'];
            if ($files['image']->getError() !== UPLOAD_ERR_NO_FILE) {
                $result = $this->checkImageFull($files['image'], $this->getData());
                if (!empty($result)) {
                    return $this->html($data + $data2 + $result, 'edit');
                }
                $this->changeImage($work, $files['image']);
            }
            parent::workEdit($d, $files['image'], $work);
            $movieDetail->setLength((int)$d['movieLength']);
            $movieDetail->setProdCompany(trim($d['prodCompany']));
            $movieDetail->setDirector(trim($d['director']));
            $movieDetail->save();
        } else {
            $text = 'Filmové údaje obsahujú chyby.';
            $color = 'danger';
        }
        return $this->html($data + $data2 + compact('text', 'color'), 'edit');
    }

    public function delete(Request $request): Response
    {
        $data = $this->checkForExistence($request);
        $work = $data['work'];
        $movieDetail = $data['movieDetail'];
        $movieDetail->delete();
        parent::workDelete($work);
        $text = 'Film bol úspešne zmazaný.';
        $color = 'success';
        return $this->redirect($this->url('home.index', compact('text', 'color')));
    }

    public function checkForExistence(Request $request): array
    {
        $workId = (int)$request->value('id');
        $work = Work::getOne($workId);
        if (!$work) {
            throw new \Exception('Film s daným ID neexistuje.');
        }
        $movieDetail = MovieDetail::getOne($workId);
        if (!$movieDetail) {
            throw new Exception("Detaily filmu nenájdené.");
        }
        return compact('work', 'movieDetail');
    }

    public function getData() : array
    {
        $countries = Country::getAll();
        $genres = Genre::getAll(whereClause: '(`type` = ? OR `type` = ?)', whereParams: ['Kino', 'Obidva']);
        $limit = TypesOfWork::Film->value;
        return compact('countries', 'genres', 'limit');
    }

    public function page(Request $request): Response
    {
        $data = parent::initialPage($request);
        $movieDetail = MovieDetail::getOne($data['work']->getId());
        return $this->html($data + compact('movieDetail'));
    }

    public function check($data, $file) : bool
    {
        if (!parent::check($data, $file) || !$this->checkLength($data['movieLength']) || !parent::checkDateOfIssue($data['dateOfIssue'], TypesOfWork::Film->value) ||
            !$this->checkProdCompany($data['prodCompany']) || !$this->checkDirector($data['director'])) {
            return false;
        }
        return true;
    }

    public function checkLength(string $length) : bool
    {
        $length = filter_var($length, FILTER_VALIDATE_INT);
        if ($length === false || $length < 1 || $length > 600) {
            return false;
        }
        return true;
    }

    public function checkProdCompany(string $prodCompany) : bool
    {
        $prodCompany = trim($prodCompany);
        if (empty($prodCompany) || mb_strlen($prodCompany) < 2 || mb_strlen($prodCompany) > 255 || !preg_match('/^[\p{L}0-9 .,&\'\-]+$/u', $prodCompany) || !preg_match('/^[\p{Lu}0-9]$/u', mb_substr($prodCompany, 0, 1, 'UTF-8'))) {
            return false;
        }
        return true;
    }

    public function checkDirector(string $director) : bool
    {
        $director = trim($director);
        if (empty($director) || mb_strlen($director) < 5 || mb_strlen($director) > 255 || !preg_match('/^[\p{L} \'\-]+$/u', $director) || !preg_match('/^\p{Lu}$/u', mb_substr($director, 0, 1, 'UTF-8'))) {
            return false;
        }
        return true;
    }
}