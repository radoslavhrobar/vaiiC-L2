<?php

namespace App\Controllers;

use App\Helpers\TypesOfWork;
use App\Models\Country;
use App\Models\Genre;
use App\Models\SeriesDetail;
use App\Models\Work;
use Exception;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class SeriesDetailController extends WorkController
{
    public function index(Request $request): Response
    {
        return $this->html();
    }
    public function add(Request $request): Response
    {
        $data = $this->getData();
        return $this->html($data);
    }

    public function addSeries(Request $request): Response
    {
        $d = $request->post();
        $files = $request->file();
        if (!isset($d['workName'], $d['genre'], $d['dateOfIssue'], $d['placeOfIssue'], $d['description'], $files['image'], $d['numOfSeasons'], $d['numOfEpisodes'],
            $d['prodCompany'], $d['director'])) {
            throw new \Exception('Nedostatočné údaje pre pridanie seriálu.');
        }
        $text = 'Seriál bol úspešne pridaný.';
        $color = 'success';
        $data = $this->getData();
        if ($this->check($d, $files['image'])) {
            $result = $this->checkImageFull($files['image'], $data);
            if (!empty($result)) {
                return $this->html($result, 'add');
            }
            $work = parent::workAdd($d, $files['image'], TypesOfWork::Seriál->name);
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
        return $this->html($data + compact( 'text', 'color'), 'add');
    }

    public function edit(Request $request): Response
    {
        $data1 = $this->checkForExistence($request);
        $data2 = $this->getData();
        return $this->html($data1 + $data2);
    }

    public function editSeries(Request $request): Response
    {
        $data = $this->checkForExistence($request);
        $d = $request->post();
        $files = $request->file();
        if (!isset($d['workName'], $d['genre'], $d['dateOfIssue'], $d['placeOfIssue'], $d['description'], $files['image'], $d['numOfSeasons'], $d['numOfEpisodes'],
            $d['prodCompany'], $d['director'])) {
            throw new \Exception('Nedostatočné údaje pre upravenie seriálu.');
        }
        $text = 'Seriál bol úspešne upravený.';
        $color = 'success';
        $data2 = $this->getData();
        if ($this->check($d, $files['image'])) {
            $work = $data['work'];
            $seriesDetail = $data['seriesDetail'];
            if ($files['image']->getError() !== UPLOAD_ERR_NO_FILE) {
                $result = $this->checkImageFull($files['image'], $this->getData());
                if (!empty($result)) {
                    return $this->html($data + $data2 + $result, 'edit');
                }
                $this->changeImage($work, $files['image']);
            }
            parent::workEdit($d, $files['image'], $work);
            $seriesDetail->setNumOfSeasons((int)$d['numOfSeasons']);
            $seriesDetail->setNumOfEpisodes((int)$d['numOfEpisodes']);
            $seriesDetail->setProdCompany(trim($d['prodCompany']));
            $seriesDetail->setDirector(trim($d['director']));
            $seriesDetail->save();
        } else {
            $text = 'Seriálové údaje obsahujú chyby.';
            $color = 'danger';
        }
        return $this->html($data + $data2 + compact( 'text', 'color'), 'edit');
    }

    public function delete(Request $request): Response
    {
        $data = $this->checkForExistence($request);
        $work = $data['work'];
        $seriesDetail = $data['seriesDetail'];
        $seriesDetail->delete();
        parent::workDelete($work);
        $text = 'Seriál bol úspešne zmazaný.';
        $color = 'success';
        return $this->redirect($this->url('home.index', compact('text', 'color')));
    }

    public function checkForExistence(Request $request): array
    {
        $workId = (int)$request->value('id');
        $work = Work::getOne($workId);
        if (!$work) {
            throw new \Exception('Seriál s daným ID neexistuje.');
        }
        $seriesDetail = SeriesDetail::getOne($workId);
        if (!$seriesDetail) {
            throw new Exception("Detaily seriálu nenájdené.");
        }
        return compact('work', 'seriesDetail');
    }

    public function getData() : array
    {
        $countries = Country::getAll();
        $genres = Genre::getAll(whereClause: '(`type` = ? OR `type` = ?)', whereParams: ['Kino', 'Obidva']);
        $limit = TypesOfWork::Seriál->value;
        return compact('countries', 'genres', 'limit');
    }

    public function page(Request $request): Response
    {
        $data = parent::initialPage($request);
        $seriesDetail = SeriesDetail::getOne($data['work']->getId());
        return $this->html($data + compact('seriesDetail'));
    }

    public function check($data, $file) : bool
    {
        if (!parent::check($data, $file) || !parent::checkDateOfIssue($data['dateOfIssue'], TypesOfWork::Seriál->value) || !$this->checkNumOfSeasons($data['numOfSeasons']) ||
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