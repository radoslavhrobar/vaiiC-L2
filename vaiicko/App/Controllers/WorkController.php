<?php

namespace App\Controllers;

use App\Helpers\Types;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Work;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class WorkController extends BaseController
{

    public function index(Request $request): Response
    {
        return $this->html();
    }

    public function rankings(Request $request): Response
    {
        return $this->html();
    }

    public function adding(Request $request): Response
    {
        return $this->html();
    }

    public function workAdd($d): ?Work
    {
        $work = new Work();
        $work->setName($d['workName']);
        $work->setType(Types::Movie->name);
        $genres = Genre::getAll(whereClause: '`name` = ?', whereParams: [$d['genre']]);
        $work->setGenre($genres[0]->getId());
        $work->setDateOfIssue($d['dateOfIssue']);
        $work->setPlaceOfIssue($d['placeOfIssue']);
        $work->setDescription($d['description']);
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
        if (empty($workName) || (mb_strlen($workName) < 2 || mb_strlen($workName) > 255)) {
            return false;
        }
        if (!preg_match('/^[a-zA-ZáäčďéëíĺľňóöôřšťúüýžÁÄČĎÉËÍĹĽŇÓÖÔŘŠŤÚÜÝŽ0-9 :,.\'-]+$/u', $workName)) {
            return false;
        }
        return true;
    }

    public function checkGenre(string $genre): bool
    {
        if (empty($genre)) {
            return false;
        }
        $genres = Genre::getAll(whereClause: '`name` = ?', whereParams: [$genre]);
        if (empty($genres)) {
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

    public function checkPlaceOfIssue(string $name): bool
    {
        if (empty($name)) {
            return false;
        }
        $countries = Country::getAll(whereClause: '`name` = ?', whereParams: [$name]);
        if (empty($countries)) {
            return false;
        }
        return true;
    }

    public function checkDescription(string $description): bool
    {
        $description = trim($description);
        if (empty($description) || (mb_strlen($description) < 3 || mb_strlen($description) > 2000)) {
            return false;
        }
        return true;
    }
}