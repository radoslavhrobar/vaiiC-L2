<?php

namespace App\Controllers;

use App\Models\Review;
use Exception;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class ReviewController extends BaseController
{
    public function index(Request $request): Response
    {
        return $this->html();
    }

    public function add(Request $request): Response
    {
        $user = $this->app->getAuth()->getUser();
        if (!$user) {
            throw new Exception("Používateľ nenájdený.");
        }
        $data = $request->post();
        $dataGet = $request->get();
        if (!isset($data['body'], $data['rating'], $dataGet['workId'])) {
            throw new Exception("Nedostatočné údaje o recenzii.");
        }
        $text = 'Hodnotenie bolo upravené.';
        $color = 'success';
        if ($this->checkBody($data['body']) && $this->checkRating($data['rating'])) {
            $review = new Review();
            if (!empty($data['body'])) {
                $review->setBody($data['body']);
                $text = 'Recenzia bola upravená.';
            }
            $review->setRating((int)$data['rating']);
            $review->setWorkId((int)$dataGet['workId']);
            $review->setUserId($user->getId());
            $review->setCreatedAt(date('Y-m-d H:i:s'));
            $review->save();
        } else {
            $text = 'Neplatné údaje o recenzii.';
            $color = 'danger';
        }
        return $this->redirect($this->url("work.ownPage", ['id' => $dataGet['workId'], 'text' => $text, 'color' => $color]));
    }

    public function edit(Request $request): Response
    {
        $data = $request->post();
        $dataGet = $request->get();
        if (!isset($data['body'], $data['rating'], $dataGet['workId'], $dataGet['id'])) {
            throw new Exception("Nedostatočné údaje o recenzii.");
        }
        $text = 'Hodnotenie bolo upravené.';
        $color = 'success';
        if ($this->checkBody($data['body']) && $this->checkRating($data['rating'])) {
            $review = Review::getOne($dataGet['id']);
            if (!empty($data['body'])) {
                $review->setBody($data['body']);
                $text = 'Recenzia bola upravená.';
            }
            $review->setRating((int)$data['rating']);
            $review->setUpdatedAt(date('Y-m-d H:i:s'));
            $review->save();
        } else {
            $text = 'Neplatné údaje o recenzii.';
            $color = 'danger';
        }
        return $this->redirect($this->url("work.ownPage", ['id' => $dataGet['workId'], 'text' => $text, 'color' => $color]));
    }

    public function checkBody(string $body): bool
    {
        if (empty($body)) {
            return true;
        }
        $body = trim($body);
        if (empty($body) || strlen($body) < 10) {
            return false;
        }
        return true;
    }

    public function checkRating(string $rating): bool
    {
        if (empty($rating) || (int)$rating < 1 || (int)$rating > 5) {
            return false;
        }
        return true;
    }
}