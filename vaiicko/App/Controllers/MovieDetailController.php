<?php

namespace App\Controllers;

use App\Helpers\TypesOfWork;
use App\Models\Country;
use App\Models\Genre;
use App\Models\MovieDetail;
use App\Models\Work;
use DateTime;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class MovieDetailController extends WorkController
{
    public function index(Request $request): Response
    {
        return $this->html();
    }
    public function form(Request $request): Response
    {
        $countries = Country::getAll();
        $genres = Genre::getAll(whereClause: '(`type` = ? OR `type` = ?)', whereParams: ['Kino', 'Obidva']);
        return $this->html(compact('countries', 'genres'));
    }

    public function add(Request $request): Response
    {
        $d = $request->post();
        if (!isset($d['workName'], $d['genre'], $d['dateOfIssue'], $d['placeOfIssue'], $d['description'], $d['movieLength'], $d['prodCompany'], $d['director'])) {
            throw new \Exception('Nedostatočné údaje pre pridanie filmu.');
        }
        $text = 'Film bol úspešne pridaný.';
        $color = 'success';
        if ($this->check($d)) {
            $work = parent::workAdd($d, TypesOfWork::Film->name);
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
        $countries = Country::getAll();
        $genres = Genre::getAll(whereClause: '(`type` = ? OR `type` = ?)', whereParams: ['Kino', 'Obidva']);
        return $this->html(compact('countries', 'genres', 'text', 'color'), 'form');
    }

    public function check($data) : bool
    {
        if (!parent::check($data) || !$this->checkLength($data['movieLength']) || !parent::checkDateOfIssue($data['dateOfIssue'], TypesOfWork::Film->value) ||
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
        if (empty($prodCompany) || mb_strlen($prodCompany) > 255 || !preg_match('/^[\p{L}0-9 .,&\'\-]+$/u', $prodCompany) || !preg_match('/^\p{Lu}$/u', mb_substr($prodCompany, 0, 1, 'UTF-8'))) {
            return false;
        }
        return true;
    }

    public function checkDirector(string $director) : bool
    {
        $director = trim($director);
        if (empty($director) || mb_strlen($director) > 100 || !preg_match('/^[\p{L} \'\-]+$/u', $director) || !preg_match('/^\p{Lu}$/u', mb_substr($director, 0, 1, 'UTF-8'))) {
            return false;
        }
        return true;
    }
}