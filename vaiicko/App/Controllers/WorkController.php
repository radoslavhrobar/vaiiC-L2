<?php

namespace App\Controllers;

use App\Models\Country;
use App\Models\Genre;
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

    public function movieForm(Request $request): Response
    {
        $countries = Country::getAll();
        $genres = Genre::getAll(whereClause: '(`type` = ? OR `type` = ?)', whereParams: ['Cinema', 'Both']);
        return $this->html(compact('countries', 'genres'));
    }

    public function addMovie(Request $request): Response
    {
        return $this->html();
    }

    public function seriesForm(Request $request): Response
    {
        $countries = Country::getAll();
        $genres = Genre::getAll(whereClause: '(`type` = ? OR `type` = ?)', whereParams: ['Cinema', 'Both']);
        return $this->html(compact('countries', 'genres'));
    }

    public function addSeries(Request $request): Response
    {
        return $this->html();
    }

    public function bookForm(Request $request): Response
    {
        $countries = Country::getAll();
        $genres = Genre::getAll(whereClause: '(`type` = ? OR `type` = ?)', whereParams: ['Book', 'Both']);
        return $this->html(compact('countries', 'genres'));
    }

    public function addBook(Request $request): Response
    {
        return $this->html();
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
        $genres = Genre::getAll(whereClause: '`name` = ?', whereParams: [$genre]);
        if (empty($genre) || empty($genres)) {
            return false;
        }
        return true;
    }
}