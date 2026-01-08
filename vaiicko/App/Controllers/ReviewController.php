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
        $review = new Review();
        if (!empty($data['body'])) {
            $review->setBody($data['body']);
        }
        $review->setRating((int)$data['rating']);
        $review->setWorkId((int)$dataGet['workId']);
        $review->setUserId($user->getId());
        $review->setCreatedAt(date('Y-m-d H:i:s'));
        $review->save();
        return $this->redirect($this->url("work.ownPage", ['id' => $dataGet['workId']]));
    }

    public function edit(Request $request): Response
    {
        $data = $request->post();
        $dataGet = $request->get();
        if (!isset($data['body'], $data['rating'], $dataGet['workId'], $dataGet['id'])) {
            throw new Exception("Nedostatočné údaje o recenzii.");
        }
        $review = Review::getOne($dataGet['id']);
        if (!empty($data['body'])) {
            $review->setBody($data['body']);
        }
        $review->setRating((int)$data['rating']);
        $review->setUpdatedAt(date('Y-m-d H:i:s'));
        $review->save();
        return $this->redirect($this->url("work.ownPage", ['id' => $dataGet['workId']]));
    }
}