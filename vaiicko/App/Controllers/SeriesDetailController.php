<?php

namespace App\Controllers;

use App\Controllers\WorkController;
use App\Helpers\TypesOfWork;
use App\Models\Country;
use App\Models\Genre;
use App\Models\SeriesDetail;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class SeriesDetailController extends WorkController
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
        if (!isset($d['workName'], $d['genre'], $d['dateOfIssue'], $d['placeOfIssue'], $d['description'], $d['numOfSeasons'], $d['numOfEpisodes'],
            $d['prodCompany'], $d['director'])) {
            throw new \Exception('Nedostatočné údaje pre pridanie seriálu.');
        }
        $text = 'Seriál bol úspešne pridaný.';
        $color = 'success';
        if ($this->check($d)) {
            $work = parent::workAdd($d, TypesOfWork::Seriál->name);
            $seriesDetail = new SeriesDetail();
            $seriesDetail->setWorkId($work->getId());
            $seriesDetail->setNumOfSeasons((int)$d['numOfSeasons']);
            $seriesDetail->setNumOfEpisodes((int)$d['numOfEpisodes']);
            $seriesDetail->setProdCompany(trim($d['prodCompany']));
            $seriesDetail->setDirector(trim($d['director']));
            $seriesDetail->save();
        } else {
            $text = 'Seriálové údaje obsahujú chyby.';
            $color = 'danger';
        }
        $countries = Country::getAll();
        $genres = Genre::getAll(whereClause: '(`type` = ? OR `type` = ?)', whereParams: ['Kino', 'Obidva']);
        return $this->html(compact('countries', 'genres', 'text', 'color'), 'form');
    }

    public function check($data) : bool
    {
        if (!parent::check($data) || !parent::checkDateOfIssue($data['dateOfIssue'], TypesOfWork::Seriál->value) || !$this->checkNumOfSeasons($data['numOfSeasons']) ||
            !$this->checkNumOfEpisodes($data['numOfEpisodes']) || !$this->checkSeasonsEpisodesNumLogic($data['numOfSeasons'], $data['numOfEpisodes']) ||
            !$this->checkProdCompany($data['prodCompany']) || !$this->checkDirector($data['director'])) {
            return false;
        }
        return true;
    }

    public function checkNumOfSeasons(string $numOfSeasons): bool
    {
        return filter_var($numOfSeasons, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1, 'max_range' => 50]
        ]);
    }

    public function checkNumOfEpisodes(string $numOfEpisodes): bool
    {
        return filter_var($numOfEpisodes, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1, 'max_range' => 3000]
        ]);
    }

    public function checkSeasonsEpisodesNumLogic(string $numOfSeasons, string $numOfEpisodes): bool
    {
        $avgEpisodesPerSeason = (int)$numOfEpisodes / (int)$numOfSeasons;
        if ($avgEpisodesPerSeason < 1 || $avgEpisodesPerSeason > 50) {
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