<?php

namespace App\Controllers;

use App\Models\Review;
use App\Models\Work;
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
        $text = 'Hodnotenie bolo pridané.';
        $color = 'success';
        if ($this->checkBody($data['body']) && $this->checkRating($data['rating'])) {
            $review = new Review();
            if (!empty($data['body'])) {
                $review->setBody($data['body']);
                $text = 'Recenzia bola pridaná.';
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
        return $this->redirectToWork($dataGet['workId'], $text, $color);
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
            } else {
                $review->setBody(null);
            }
            $review->setRating((int)$data['rating']);
            $review->setUpdatedAt(date('Y-m-d H:i:s'));
            $review->save();
        } else {
            $text = 'Neplatné údaje o recenzii.';
            $color = 'danger';
        }
        return $this->redirectToWork($dataGet['workId'], $text, $color);
    }

    public function redirectToWork($workId, string $text, string $color): \Framework\Http\Responses\RedirectResponse
    {
        $work = Work::getOne($workId);
        if ($work->getType() === 'Film') {
            $page = "movieDetail.page";
        } else if ($work->getType() === 'Seriál') {
            $page = "seriesDetail.page";
        } else {
            $page = "bookDetail.page";
        }
        return $this->redirect($this->url($page, ['id' => $workId, 'text' => $text, 'color' => $color]));
    }

    public function checkBody(string $body): bool
    {
        if (empty($body)) {
            return true;
        }
        $body = trim($body);
        if (empty($body) || strlen($body) < 10 || !preg_match('/^[\p{Lu}0-9]$/u', mb_substr($body, 0, 1, 'UTF-8'))) {
            return false;
        }
        return true;
    }

    public function checkRating(string $rating): bool
    {
        if (empty($rating) || !in_array((int)$rating, [1, 2, 3, 4, 5], true)) {
            return false;
        }
        return true;
    }
}