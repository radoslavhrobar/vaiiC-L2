<?php

namespace App\Controllers;

use App\Controllers\WorkController;
use App\Helpers\TypesOfWork;
use App\Models\BookDetail;
use App\Models\Country;
use App\Models\Genre;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class BookDetailController extends WorkController
{
    public function index(Request $request): Response
    {
        return $this->html();
    }
    public function form(Request $request): Response
    {
        $countries = Country::getAll();
        $genres = Genre::getAll(whereClause: '(`type` = ? OR `type` = ?)', whereParams: ['Kniha', 'Obidva']);
        return $this->html(compact('countries', 'genres'));
    }

    public function add(Request $request): Response
    {
        $d = $request->post();
        if (!isset($d['workName'], $d['genre'], $d['dateOfIssue'], $d['placeOfIssue'], $d['description'], $d['numOfPages'], $d['publishers'], $d['author'])) {
            throw new \Exception('Nedostatočné údaje pre pridanie knihy.');
        }
        $text = 'Kniha bola úspešne pridaná.';
        $color = 'success';
        if ($this->check($d)) {
            $work = parent::workAdd($d, TypesOfWork::Kniha->name);
            $bookDetail = new BookDetail();
            $bookDetail->setWorkId($work->getId());
            $bookDetail->setNumOfPages((int)$d['numOfPages']);
            $bookDetail->setPublishers(trim($d['publishers']));
            $bookDetail->setAuthor(trim($d['author']));
            $bookDetail->save();
        } else {
            $text = 'Knižné údaje obsahujú chyby.';
            $color = 'danger';
        }
        $countries = Country::getAll();
        $genres = Genre::getAll(whereClause: '(`type` = ? OR `type` = ?)', whereParams: ['Kniha', 'Obidva']);
        return $this->html(compact('countries', 'genres', 'text', 'color'), 'form');
    }

    public function check($data): bool
    {
        if (!parent::check($data) || !$this->checkNumOfPages($data['numOfPages']) || !parent::checkDateOfIssue($data['dateOfIssue'], TypesOfWork::Kniha->value) ||
            !$this->checkPublishers($data['publishers']) || !$this->checkAuthor($data['author'])) {
            return false;
        }
        return true;
    }

    public function checkNumOfPages(string $numOfPages): bool
    {
        return filter_var($numOfPages, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1, 'max_range' => 5000]
        ]);
    }

    public function checkPublishers(string $publishers) : bool
    {
        $publishers = trim($publishers);
        if (empty($publishers) || mb_strlen($publishers) > 255 || !preg_match('/^[\p{L}0-9 .,&\'\-]+$/u', $publishers) || !preg_match('/^\p{Lu}$/u', mb_substr($publishers, 0, 1, 'UTF-8'))) {
            return false;
        }
        return true;
    }

    public function checkAuthor(string $author) : bool
    {
        $author = trim($author);
        if (empty($author) || mb_strlen($author) > 100 || !preg_match('/^[\p{L} \'\-]+$/u', $author) || !preg_match('/^\p{Lu}$/u', mb_substr($author, 0, 1, 'UTF-8'))) {
            return false;
        }
        return true;
    }
}