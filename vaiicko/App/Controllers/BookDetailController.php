<?php

namespace App\Controllers;

use App\Helpers\TypesOfWork;
use App\Models\BookDetail;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Work;
use Exception;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class BookDetailController extends WorkController
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

    public function addBook(Request $request): Response
    {
        $d = $request->post();
        $files = $request->file();
        if (!isset($d['workName'], $d['genre'], $d['dateOfIssue'], $d['placeOfIssue'], $d['description'], $files['image'], $d['numOfPages'], $d['publishers'], $d['author'])) {
            throw new \Exception('Nedostatočné údaje pre pridanie knihy.');
        }
        $text = 'Kniha bola úspešne pridaná.';
        $color = 'success';
        $data = $this->getData();
        if ($this->check($d, $files['image'])) {
            $result = $this->checkImageFull($files['image'], $data);
            if (!empty($result)) {
                return $this->html($result, 'add');
            }
            $work = parent::workAdd($d, $files['image'], TypesOfWork::Kniha->name);
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
        return $this->html(compact('text', 'color') + $data, 'add');
    }

    public function edit(Request $request): Response
    {
        $data1 = $this->checkForExistence($request);
        $data2 = $this->getData();
        return $this->html($data1 + $data2);
    }

    public function editBook(Request $request): Response
    {
        $data = $this->checkForExistence($request);
        $d = $request->post();
        $files = $request->file();
        if (!isset($d['workName'], $d['genre'], $d['dateOfIssue'], $d['placeOfIssue'], $d['description'], $files['image'], $d['numOfPages'], $d['publishers'], $d['author'])) {
            throw new \Exception('Nedostatočné údaje pre upravnie knihy.');
        }
        $text = 'Kniha bola úspešne upravená.';
        $color = 'success';
        if ($this->check($d, $files['image'])) {
            $work = $data['work'];
            $bookDetail = $data['bookDetail'];
            parent::workEdit($d, $files['image'], $work);
            $bookDetail->setNumOfPages((int)$d['numOfPages']);
            $bookDetail->setPublishers(trim($d['publishers']));
            $bookDetail->setAuthor(trim($d['author']));
            $bookDetail->save();
        } else {
            $text = 'Knižné údaje obsahujú chyby.';
            $color = 'danger';
        }
        $data2 = $this->getData();
        return $this->html($data + $data2 + compact( 'text', 'color'), 'edit');
    }

    public function checkForExistence(Request $request): array
    {
        $workId = (int)$request->value('id');
        $work = Work::getOne($workId);
        if (!$work) {
            throw new \Exception('Kniha s daným ID neexistuje.');
        }
        $bookDetail = BookDetail::getOne($workId);
        if (!$bookDetail) {
            throw new Exception("Detaily knihynenájdené.");
        }
        return compact('work', 'bookDetail');
    }

    public function getData() : array
    {
        $countries = Country::getAll();
        $genres = Genre::getAll(whereClause: '(`type` = ? OR `type` = ?)', whereParams: ['Kniha', 'Obidva']);
        $limit = TypesOfWork::Kniha->value;
        return compact('countries', 'genres', 'limit');
    }

    public function page(Request $request): Response
    {
        $data = parent::initialPage($request);
        $bookDetail = BookDetail::getOne($data['work']->getId());
        return $this->html($data + compact('bookDetail'));
    }

    public function check($data, $file): bool
    {
        if (!parent::check($data, $file) || !$this->checkNumOfPages($data['numOfPages']) || !parent::checkDateOfIssue($data['dateOfIssue'], TypesOfWork::Kniha->value) ||
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
        if (empty($publishers) || mb_strlen($publishers) < 2 || mb_strlen($publishers) > 255 || !preg_match('/^[\p{L}0-9 .,&\'\-]+$/u', $publishers) || !preg_match('/^[\p{Lu}0-9]$/u', mb_substr($publishers, 0, 1, 'UTF-8'))) {
            return false;
        }
        return true;
    }

    public function checkAuthor(string $author) : bool
    {
        $author = trim($author);
        if (empty($author) || mb_strlen($author) < 5 || mb_strlen($author) > 255 || !preg_match('/^[\p{L} \'\-]+$/u', $author) || !preg_match('/^\p{Lu}$/u', mb_substr($author, 0, 1, 'UTF-8'))) {
            return false;
        }
        return true;
    }
}